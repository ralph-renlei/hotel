@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <form action="/admin/shop/price/save" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="hidden" name="id" value="{{$price->id}}"/>
                <div class="modal-content">

                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="price_store">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">分类<span style="color:red">*</span></label>
                                <div class="col-sm-3" id="category">
                                    <select class="form-control" name="category" id="category">
                                        <option value ="0">请选择分类</option>
                                        @foreach($list as $category)
                                            <option value ="{{$category->id}}" @if($price->id==$category->id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><br><br>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">挂牌价<span style="color:red">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="marketprice" class="form-control" id="marketprice" placeholder="请输入数字" value="{{$price->marketprice}}">
                                </div>
                            </div><br><br>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">普通价<span style="color:red">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="normalprice" class="form-control" id="normalprice" placeholder="请输入数字" value="{{$price->normalprice}}">
                                </div>
                            </div><br><br>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">会员价<span style="color:red">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" name="vipprice" class="form-control" id="vipprice" placeholder="请输入数字" value="{{$price->vipprice}}">
                                </div>
                            </div><br><br>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">开始时间<span style="color:red">*</span></label>
                                <div class="col-sm-3">
                                    <input class=" form-control" type="text" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd})" name="start" value="{{$price->start}}">
                                </div>
                            </div><br><br>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">结束时间<span style="color:red">*</span></label>
                                <div class="col-sm-3">
                                    <input class=" form-control" type="text" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="end" value="{{$price->end}}">
                                </div>
                            </div><br><br>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default" data-dismiss="modal">重置</button>
                        <button type="submit" class="btn btn-primary">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection