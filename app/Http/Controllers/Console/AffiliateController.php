<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Http\Requests;
use WxHotel\User;
use Illuminate\Http\Request;

class AffiliateController extends Controller {

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        $var = array();

        return view('admin.affiliate.home',$var);
	}

	public function show($id)
	{
		//
        $var = array();
        $list = User::where('pid',$id)->orderBy('id','desc')->paginate(20);
        $list->setPath('admin/user/affiliate/'.$id);
        $var['lists'] = $list;
        $var['user'] = User::find($id);
        return view('admin.affiliate.affiliate',$var);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
