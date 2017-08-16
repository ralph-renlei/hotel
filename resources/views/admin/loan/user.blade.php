@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">认证资料</div>
				<div class="panel-body">
					@if(count($errors) > 0)
						<div class="alert alert-danger">
							<strong>对不起，有错误发生！</strong><br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                        <div class="col-md-offset-1">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active" onclick="app.house.nav_tab('base')" id="base_li"><a href="javascript:void(0)">基本信息</a></li>
                                <li role="presentation" onclick="app.house.nav_tab('debts')" id="debts_li"><a href="javascript:void(0)">债务</a></li>
                                <li role="presentation" onclick="app.house.nav_tab('jobs')" id="jobs_li"><a href="javascript:void(0)">工作</a></li>
                                <li role="presentation" onclick="app.house.nav_tab('loan')" id="loan_li"><a href="javascript:void(0)">贷款用途</a></li>
                                <li role="presentation" onclick="app.house.nav_tab('aduit')" id="aduit_li"><a href="javascript:void(0)">审核</a></li>
                            </ul>
                        </div>
                        <div style="margin-top:15px;">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/loan/identify') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group base">
                                <label class="col-md-4 control-label">姓名</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $item->name }}" placeholder="请输入姓名"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">手机</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mobile" id="mobile" value="{{ $item->mobile }}" placeholder="请输入手机号码"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">邮箱</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $item->email }}" placeholder="请输入邮箱"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">身高</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="height" id="height" value="{{ $item->height }}" placeholder="请输入身高"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">体重</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="weight" id="weight" value="{{ $item->weight }}" placeholder="请输入体重"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">身份证</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="idcard_no" id="idcard_no" value="{{ $item->idcard_no }}" placeholder="请输入身份证号码"/>
                                </div>
                                <div>
                                    <a href="{{ $item->idcard_front }}" title="点击查看大图"><img src="{{ $item->idcard_front }}" id="idcard_front" class="img_all img_idcard"/></a>
                                    <a href="{{ $item->idcard_back }}" title="点击查看大图"><img src="{{ $item->idcard_back }}" id="idcard_back" class="img_all"/></a>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">微信号</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="wechatid" id="wechatid" value="{{ $item->wechatid }}" placeholder="请输入微信号"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">驾照</label>
                                <div class="col-md-6">
                                    <div>
                                        <a href="{{ $item->licence }}" title="点击查看大图"><img src="{{ $item->licence }}" id="licence" class="img_all"/></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">护照</label>
                                <div class="col-md-6">
                                    <div>
                                        <a href="{{ $item->passport }}" title="点击查看大图"><img src="{{ $item->passport }}" id="passport" class="img_all"/></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">港澳通行证</label>
                                <div class="col-md-6">
                                    <div>
                                        <a href="{{ $item->hk_passport }}" title="点击查看大图"><img src="{{ $item->hk_passport }}" id="hk_passport" class="img_all"/></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">台湾自由行</label>
                                <div class="col-md-6">
                                    <div>
                                        <a href="{{ $item->taiwan_permit }}" title="点击查看大图"><img src="{{ $item->taiwan_permit }}" id="taiwan_permit" class="img_all"/></a>
                                    </div>
                                </div>
                            </div>
                            @if($item->has_car==1)
                            <div class="form-group base">
                                <label class="col-md-4 control-label">车</label>
                                <div class="col-md-6">
                                    <div>
                                        <a href="{{ $item->car }}" title="点击查看大图"><img src="{{ $item->car }}" id="car" class="img_all"/></a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="form-group base">
                                <label class="col-md-4 control-label">房产</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="residence" id="residence" value="{{ $item->residence }}" placeholder="请输入房产信息"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">户口所在地</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" id="address" value="{{ $item->address }}" placeholder="请输入户口所在地"/>
                                </div>
                            </div>
                            <div class="form-group base">
                                <label class="col-md-4 control-label">现居地址</label>
                                <div class="col-md-6">
                                    <div>
                                        <a href="{{ $item->household }}" title="点击查看大图"><img src="{{ $item->household }}" id="household" class="img_all"/></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">房贷</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="house_loan" id="house_loan" @if(isset($debts))value="{{ $debts->house_loan }}"@endif placeholder="请输入房贷"/>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">车贷</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="car_loan" id="car_loan" @if(isset($debts))value="{{ $debts->car_loan }}"@endif placeholder="请输入车贷"/>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">信用卡</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="credit_card" id="credit_card" @if(isset($debts))value="{{ $debts->credit_card }}"@endif placeholder="请输入信用卡"/>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">手机分期</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="mobile_loan" id="mobile_loan" @if(isset($debts))value="{{ $debts->mobile_loan }}"@endif placeholder="请输入手机分期"/>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">网贷</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="web_loan" id="web_loan" @if(isset($debts))value="{{ $debts->web_loan }}"@endif placeholder="请输入网贷"/>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">其他贷款</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="other_loan" id="other_loan" @if(isset($debts))value="{{ $debts->other_loan }}"@endif placeholder="请输入其他贷款"/>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">生活照</label>
                                <div>
                                    @if(isset($debts->images))<a href="{{ $item->images }}" title="点击查看大图"><img src="{{ $debts->images }}" class="img_all"/></a>@endif
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">紧急联系人</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="urgency_contacter" id="urgency_contacter" @if(isset($debts))value="{{ $debts->urgency_contacter }}"@endif placeholder="请输入紧急联系人"/>
                                </div>
                            </div>
                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">联系人固话</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="urgency_tel" id="urgency_tel" @if(isset($debts))value="{{ $debts->urgency_tel }}"@endif placeholder="请输入联系人固话"/>
                                </div>
                            </div>

                            <div class="form-group debts" style="display: none">
                                <label class="col-md-4 control-label">联系人手机</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="urgency_mobile" id="urgency_mobile" @if(isset($debts))value="{{ $debts->urgency_mobile }}"@endif placeholder="请输入联系人手机"/>
                                </div>
                            </div>
                            <div class="form-group jobs" style="display: none">
                                <label class="col-md-4 control-label">工作性质</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="job_type" id="job_type" @if(isset($job))value="{{ $job->type }}"@endif placeholder="请输入工作性质"/>
                                </div>
                            </div>
                            <div class="form-group jobs" style="display: none">
                                <label class="col-md-4 control-label">工作单位名称</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="job_name" id="job_name" @if(isset($job))value="{{ $job->name }}"@endif placeholder="请输入工作单位名称"/>
                                </div>
                            </div>
                            <div class="form-group jobs" style="display: none">
                                <label class="col-md-4 control-label">工作时间</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="job_year" id="job_year" @if(isset($job))value="{{ $job->year }}"@endif placeholder="请输入工作时间"/>
                                </div>
                            </div>
                            <div class="form-group jobs" style="display: none">
                                <label class="col-md-4 control-label">工作单位负责人姓名</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="job_contacter" id="job_contacter" @if(isset($job))value="{{ $job->contacter }}"@endif placeholder="请输入工作单位负责人姓名"/>
                                </div>
                            </div>
                            <div class="form-group jobs" style="display: none">
                                <label class="col-md-4 control-label">工作单位负责人电话</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="job_contacter_mobile" id="job_contacter_mobile" @if(isset($job))value="{{ $job->contacter_mobile }}"@endif placeholder="请输入工作单位负责人电话"/>
                                </div>
                            </div>
                            <div class="form-group loan" style="display: none">
                                <label class="col-md-4 control-label">月收入(元)</label>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" name="salary" id="salary" @if(isset($loan))value="{{ $loan->salary }}"@endif placeholder="请输入月收入"/>
                                </div>
                            </div>
                            <div class="form-group loan" style="display: none">
                                <label class="col-md-4 control-label">分期用途</label>
                                <div class="r_cell clearfix purpose" id="purpose">
                                    <div class="purpose_wrap">
                                            @if(isset($loan->purpose_list) && in_array('整形美容',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell1" data="1">整形美容</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val1" value="整形美容"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell1" data="1">整形美容</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('奢侈品',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell2" data="2">奢侈品</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val2" value="奢侈品"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell2" data="2">奢侈品</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('购房',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell3" data="3">购房</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val3" value="购房"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell3" data="3">购房</span>
                                            @endif
                                    </div>
                                    <div class="purpose_wrap">
                                            @if(isset($loan->purpose_list) && in_array('购车',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell4" data="4">购车</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val4" value="购车"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell4" data="4">购车</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('旅游',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell5" data="5">旅游</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val5"  value="旅游"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell5" data="5">旅游</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('健身',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose"  id="purpose_cell6" data="6">健身</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val6" value="健身"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell6" data="6">健身</span>
                                            @endif
                                    </div>
                                    <div class="purpose_wrap">
                                            @if(isset($loan->purpose_list) && in_array('教育',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose"  id="purpose_cell7" data="7">教育</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val7" value="教育"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell7" data="7">教育</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('房屋租赁',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell8" data="8">房屋租赁</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val8" value="房屋租赁"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell8" data="8">房屋租赁</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('投资装修',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell9" data="9">投资装修</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val9" value="投资装修"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell9" data="9">投资装修</span>
                                            @endif
                                    </div>
                                    <div class="purpose_wrap">
                                            @if(isset($loan->purpose_list) && in_array('婚庆',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell10" data="10">婚庆</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val10" value="婚庆"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell10" data="10">婚庆</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('居家',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell11" data="11">居家</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val11" value="居家"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell11" data="11">居家</span>
                                            @endif
                                            @if(isset($loan->purpose_list) && in_array('数码产品',$loan->purpose_list,true))
                                                <span class="purpose_cell current_purpose" id="purpose_cell12" data="12">数码产品</span>
                                                <input type="hidden" name="purpose[]" id="purporse_val12" value="数码产品"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell12" data="12">数码产品</span>
                                            @endif
                                    </div>
                                    <div class="purpose_wrap">
                                            @if(isset($loan->purpose_list) && in_array('资金周转',$loan->purpose_list,true))
                                            <span class="purpose_cell current_purpose" id="purpose_cell13" data="13">资金周转</span>
                                            <input type="hidden" name="purpose[]" id="purporse_val13" value="资金周转"/>
                                            @else
                                                <span class="purpose_cell" id="purpose_cell14" data="14">资金周转</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group loan" style="display: none">
                                <label class="col-md-4 control-label">分期金额需求</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="ranges" id="ranges">
                                        <option value="5千-1万" @if(isset($loan->ranges) && $loan->ranges=='5千-1万')selected="selected"@endif>5千-1万</option>
                                        <option value="1万-1.5万" @if(isset($loan->ranges) && $loan->ranges=='1万-1.5万')selected="selected"@endif>1万-1.5万</option>
                                        <option value="1.5万-2万" @if(isset($loan->ranges) && $loan->ranges=='1.5万-2万')selected="selected"@endif>1.5万-2万</option>
                                        <option value="2万-2.5万" @if(isset($loan->ranges) && $loan->ranges=='2万-2.5万')selected="selected"@endif>2万-2.5万</option>
                                        <option value="2.5万-3万" @if(isset($loan->ranges) && $loan->ranges=='2.5万-3万')selected="selected"@endif>2.5万-3万</option>
                                        <option value="3.5万-4万" @if(isset($loan->ranges) && $loan->ranges=='3.5万-4万')selected="selected"@endif>3.5万-4万</option>
                                        <option value="4.5万-5万" @if(isset($loan->ranges) && $loan->ranges=='4.5万-5万')selected="selected"@endif>4.5万-5万</option>
                                        <option value="5.5万-6万" @if(isset($loan->ranges) && $loan->ranges=='5.5万-6万')selected="selected"@endif>5.5万-6万</option>
                                        <option value="6.5万-7万" @if(isset($loan->ranges) && $loan->ranges=='6.5万-7万')selected="selected"@endif>6.5万-7万</option>
                                        <option value="7.5万-8万" @if(isset($loan->ranges) && $loan->ranges=='7.5万-8万')selected="selected"@endif>7.5万-8万</option>
                                        <option value="8.5万-9万" @if(isset($loan->ranges) && $loan->ranges=='8.5万-9万')selected="selected"@endif>8.5万-9万</option>
                                        <option value="9.5万-10万" @if(isset($loan->ranges) && $loan->ranges=='9.5万-10万')selected="selected"@endif>9.5万-10万</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group aduit" style="display: none">
                                <label class="col-md-4 control-label">审核</label>
                                <div class="col-md-6">
                                    @if($item->verify==1 || $item->verify==-1)
                                        <label class="radio-inline">
                                            <input type="radio" name="verify" id="verify1" value="0" @if($item->verify==0)checked="checked"@endif disabled="disabled"/>
                                            未审核
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="verify" id="verify2" value="1" @if($item->verify==1)checked="checked"@endif disabled="disabled"/>
                                            已通过
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="verify" id="verify3" value="-1" @if($item->verify==-1)checked="checked"@endif disabled="disabled"/>
                                            未通过
                                        </label>
                                    @else
                                        <label class="radio-inline">
                                            <input type="radio" name="verify" id="verify1" value="0" @if($item->verify==0)checked="checked"@endif/>
                                            未审核
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="verify" id="verify2" value="1" @if($item->verify==1)checked="checked"@endif/>
                                            已通过
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="verify" id="verify3" value="-1" @if($item->verify==-1)checked="checked"@endif/>
                                            未通过
                                        </label>
                                        @endif

                                </div>
                            </div>
                            <div class="form-group aduit" style="display: none">
                                <label class="col-md-4 control-label">备注</label>
                                <div class="col-md-8">
                                    @if($item->verify==1 || $item->verify==-1)
                                        <input type="text" class="form-control" name="note" id="note" @if($loan)value="{{ $loan->note }}"@endif placeholder="请输入未通过原因" disabled="disabled"/>

                                    @else
                                        <input type="text" class="form-control" name="note" id="note" @if($loan)value="{{ $loan->note }}"@endif placeholder="请输入未通过原因"/>

                                    @endif
                                 </div>
                             </div>
                            <div class="form-group base debts jobs loan aduit">
                                <div class="col-md-6 col-md-offset-4">
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    @if((int)$item->verify==0)
                                    <button type="submit" class="btn btn-primary">保存</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                        <div class="panel-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
