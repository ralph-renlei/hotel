<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\LoanConfig;
use WxHotel\LoanRecord;
use WxHotel\RefundRecord;
use WxHotel\Services\LoanTool;
use WxHotel\Store;
use Illuminate\Http\Request;
use WxHotel\Goods;
use WxHotel\Order;
use WxHotel\User;
use WxHotel\Loan;
use Auth;
use WxHotel\OrderGoods;
use WxHotel\UserAddress;

class OrderController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$var = array();
		$keyword = $request->input('keyword');
        $Order = new Order();
        $list = $Order->getList($keyword);
		$var['list'] = $list;
		return view('admin.order.home',$var);
	}

    //分期审核
    public function getStatus($id){
        $var = [];
        $order = Order::find($id);
        $var['item'] = $order;
        $user = User::find($order->uid);

        $var['user'] = $user;
        $loan = Loan::find($order->order_id);
        $var['loan'] = $loan;

        return view('admin.order.audit',$var);
    }
    //这里只修改分期状态为已处理状态 如果是审核未通过把备注信息加上
    public function postStatus(Request $request){
		$status = $request->input('status');
		$id = $request->input('id');
        $note = $request->input('note');

        if(!isset($status) || in_array($status,array(0,1,-1),true)){
            return redirect()->back()->withErrors(['error' => '状态不合法']);
        }
        if($status==-1 && (!isset($note) || empty($note))){
            return redirect()->back()->withErrors(['error' => '备注不能为空']);
        }

		$Order = Order::find($id);
        if(empty($Order) || $Order->status==1){
            return redirect()->back()->withErrors(['error' => '分期不存在或者不能修改']);
        }

		$Order->order_status = $status;
        if(isset($note)){
            $Order->note = $note;
        }
        $Order->confirm_time = time();
        $Order->save();
        if($status==1){
            $Loan = Loan::find($Order->order_id);
            $Loan->status = 1;
            $Loan->save();
        }

        return redirect('/admin/fund');
	}

    //放款
    public function getPay($id){
        $var = [];
        $order = Order::find($id);
        $var['item'] = $order;
        $user = User::find($order->uid);
        $var['user'] = $user;
        $loan = Loan::find($order->order_id);
        $var['loan'] = $loan;
        if($order->order_status !==1 || $loan->audit !=1){
            return redirect('/admin/fund');
        }
        return view('admin.order.pay',$var);
    }

    //修改分期订单状态 pay_status pay_time paid_fee
    //计算分期利息 新增一条贷款记录
    //把每期的还款记录都在系统给用户生成
    public function postPay(Request $request){
        $return = array(
            'code'=>self::CODE_PARAM,
            'msg'=>self::PARAM_MSG
        );
        //分期ID
        $id = $request->input('id');
        //手续费
        if(empty($id)){
            return response()->json($return);
        }

        $order = Order::find($id);
        if(empty($order) || $order->order_status!=1){
            $return['msg'] = '分期不存在或审核未通过';
            return response()->json($return);
        }

        $borrower = User::find($order->uid);
        if(!isset($borrower) || $borrower->verify!=1){
            $return['msg'] = '借款人不存在或未认证';
            return response()->json($return);
        }

        $loan = Loan::find($order->order_id);
        if(empty($loan) || $loan->audit!=1){
            $return['msg'] = '分控审核未通过';
            return response()->json($return);
        }

        $config = LoanConfig::find($loan->loan_id);
        if(empty($config)){
            $return['msg'] = '分期类型不存在';
            return response()->json($return);
        }

        $LoanTool = new LoanTool($config->rate,$config->fee,$config->num,$order->pay_fee);
        if(!$LoanTool->checkLoanDay()){
            $return['msg'] = '抱歉，还没到放款日';
            return response()->json($return);
        }

        //手续费
        $poundage = $LoanTool->getPoundage();
        $refund_list = $LoanTool->getNumList();

        $user = Auth::user();
        //手续费 'num','percent','rate','capital','interest','money',
        $loan_record = array(
            'order_id'=>$order->order_id,
            'title'=>$order->uname.'分'.$loan->loan_num.'期付款'.$order->goods_name,
            'uid'=>$borrower->id,
            'channel_id'=>$borrower->pid,
            'uname'=>$borrower->name,
            'mobile'=>$borrower->moile,
            'loan_id'=>$loan->loan_id,
            'loan_num'=>$loan->loan_num,
            'loan_fee'=>$loan->loan_fee,
            'loan_rate'=>$loan->loan_rate,
            'loan_money'=>$order->pay_fee,
            'fee_money'=>$poundage,
            'poundage'=>0,
            'status'=>0,
            'rid'=>$user->id,
        );

        $LoanRecord = LoanRecord::create($loan_record);

        if(!isset($LoanRecord)){
            $return['msg'] = '放款失败，请重试';
            $return['code'] = self::CODE_FAIL;
            return response()->json($return);
        }

        foreach($refund_list as $r){
            $refund = [];
            $refund['title'] = $LoanRecord->title.'NO'.$r['num'];
            $refund['uid'] = $borrower->id;
            $refund['channel_id'] = $borrower->pid;
            $refund['uname'] = $borrower->name;
            $refund['mobile'] = $borrower->mobile;
            $refund['loan_id'] = $loan->loan_id;
            $refund['loans_id'] = $LoanRecord->id;
            $refund['order_id'] = $order->order_id;
            $refund['order_sn'] = $order->order_sn;
            $refund['num'] = $r['num'];
            $refund['percent'] = $r['percent'];
            $refund['rate'] = $r['rate'];
            $refund['capital'] = $r['capital'];
            $refund['interest'] = $r['interest'];
            $refund['money'] = $r['money'];
            $refund['fid'] = $user->id;
            $refund['status'] = 0;
            $refund['is_overdue'] = 0;
            $refund['refund_date'] = $r['refund_date'];
            RefundRecord::create($refund);
        }
        $order->pay_status = 1;
        $order->order_status = 2;
        $order->money_paid = $LoanRecord->loan_money;
        $order->pay_time = time();
        $order->save();
        $loan->status = 2;
        $loan->complete_at = date('Y-m-d H:i:s',time());
        $loan->save();
        $return['code'] = self::CODE_SUCCESS;
        $return['msg'] = self::SUCCESS_MSG;
        return response()->json($return);
    }

	public function getAdd(Request $request){
		$vars = array();
		$vars['list'] = Goods::all();
		return view('admin.order.add',$vars);
	}

	public function postAdd(Request $request){

		$this->validate($request,[
			'goods_id'=>'required|max:255',
			'goods_amount'=>'required|integer',
			'mobile'=>'required|regex:/^1[2-9]\d{9}$/|max:11',
			'username'=>'required|max:255|min:2',
			'openid'=>'required|max:255|min:28',
			'status'=>'required||in:0,1,2,3,4',
		]);

		$goods_id = $request->input('goods_id');
		$goods_amount = $request->input('goods_amount');
		$mobile = $request->input('mobile');
		$username = $request->input('username');
		$openid = $request->input('openid');
		$status = $request->input('status');
		$goods = Goods::where('goods_id',$goods_id)->first();
		$user=User::where('mobile',$mobile)->first();
		if(empty($goods) || $goods->status==0){
			return redirect()->back()->withErrors(['error' => '商品不存在或者已经下线']);
		}
		if(empty($user)||$user->verify==0){
			return redirect()->back()->withErrors(['error' => '用户不存在或者未审核']);
		}
		$o = array(
			'order_sn'=>$goods->id.time().mt_rand(0000,9999),
			'order_status'=>$status,
			'store_id'=>$goods->store_id,
			'pay_status'=>0,
			'uid'=>$user->id,
			'goods_id'=>$goods_id,
			'goods_name'=>$goods->name,
			'goods_amount'=>$goods_amount,
			'pay_fee'=>$goods->productprice*$goods_amount,
			'goods_amount'=>$goods->productprice*$goods_amount,
			'bonus'=>0,
			'order_amount'=>1,
			'affiliate'=>1,
			'froms'=>'pc',
			'add_time'=>date("YmdHis"),
		);
		$order = Order::create($o);
		return redirect('/admin/shop/order');
	}

    //修改订单
    public function postItem(Request $request){

    }

	public function getItem($id){
		$this->var['order']=Order::where('order_id',$id)->first();
		$this->var['goods']=OrderGoods::where('order_id',$this->var['order']->order_id)->get();
		$this->var['user']=User::where('id',$this->var['order']->uid)->first();
		$this->var['address']=UserAddress::where('uid',$this->var['order']->uid)->first();
//		$gallery_list = array();
//		if(!empty($this->var['goods']->images)){
//			$gallery_list = explode(',',$this->var['goods']->images);
//		}
//		$this->var['gallery_list'] = $gallery_list;
	//	var_dump($this->var['goods']->toArray());
		return view('admin.order.item',$this->var);
	}


	public function getNotice($id){
		$result = array(
			'code'=>self::CODE_FAIL,
			'msg'=>self::FAIL_MSG
		);

		if((int)$id==0){
			$result['code'] = self::CODE_PARAM;
			return response()->json($result);
		}
		$WxNotice = new WxNotice(config('wechat.app_id'), config('wechat.secret'));
		$Order = Order::find($id);
		if(empty($Order)){
			$result['msg'] = trans('error.order_error');
			return response()->json($result);
		}
		if((int)$Order->notice!=1){
			$result = $WxNotice->fillOrder($Order->buyer_openid,$Order->order_id,$Order->product_name,date('Y-m-d H:i:s',$Order->order_create_time));
			if($result){
				if($result['errcode']==0){
					$result['code'] = self::CODE_SUCCESS;
					$result['msg'] = self::SUCCESS_MSG;
					$Order->notice  = 1;
					$Order->notice_time = time();
					$Order->save();
				}
			}
		}else{
			$result['msg'] = '已经发送提醒';
		}

		return response()->json($result);
	}

	public function goods(){
		$WxGoods = new WxGoods(config('wechat.app_id'), config('wechat.secret'));
		$list = $WxGoods->getByStatus(0);
		if(!empty($list)){
			foreach($list as $item){
				$data = array(
					'product_id'=>$item['product_id'],
					'status'=>$item['status'],
					'attrext'=>json_encode($item['attrext']),
					'delivery_info'=>json_encode($item['delivery_info']),
					'sku_list'=>json_encode($item['sku_list']),
					'name'=>$item['product_base']['name'],
					'category_id'=>json_encode($item['product_base']['category_id']),
					'img'=>json_encode($item['product_base']['img']),
					'buy_limit'=>$item['product_base']['buy_limit'],
					'main_img'=>$item['product_base']['main_img'],
					'detail_html'=>$item['product_base']['detail_html'],
					'detail'=>json_encode($item['product_base']['detail']),
					'property'=>json_encode($item['product_base']['property']),
					'add_time'=>time(),
				);
				Goods::create($data);
			}
		}
	}


	//相关订单的配送统计
	public function getDeliveryTotal(Request $request){
		$var = array();

		$keyword = $request->input('keyword');
		if(empty($keyword)){
			$list = DeliveryTotal::orderBy('id','DESC')->paginate(20);
		}else{
			$list = DeliveryTotal::where('customer_mobile','LIKE','%'.$keyword.'%')->orderBy('id','DESC')->paginate(20);
		}

		$list->setPath('/admin/shop/total');
		$var['total'] = $list;
		return view('order.total',$var);
	}


	public function getDeliveryTotalDetail($id){
		$var = array();
		$DeliveryTotal = new DeliveryTotal();
		$delivery_total = $DeliveryTotal->getDeliveryTotal($id);
		$var['delivery_total'] = $delivery_total;
		return view('order.delivery_total',$var);
	}


	public function postDeliveryTotal(Request $request){
		$id = $request->input('id');

		$total = $request->input('total');
		$left_total = $request->input('left_total');
		if(empty($id)){
			return redirect()->back()->withErrors(['param' => 'ID不能为空']);
		}
		$delivery_total = DeliveryTotal::find($id);
		if(empty($delivery_total)){
			return redirect()->back()->withErrors(['param' => '配送订单不存在']);
		}
		$delivery_total->total = $total;
		$delivery_total->left_total = $left_total;
		$response = $delivery_total->save();
		if($response){
			return redirect('/shop/delivery_total/'.$id);
		}
		return redirect()->back()->withErrors(['error' => '更新失败']);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($order_id)
	{
		$WxShop = new WxShop(config('wechat.app_id'), config('wechat.secret'));
		$order = $WxShop->getOrderDetail($order_id);
		return view('order.add');
	}

}
