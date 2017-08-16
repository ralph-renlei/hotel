<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>我的账单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>
	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
		</header>


        <div class="bill_wrap">
            <p class="bill_date">账单月份</p>
            <input type="month" name="" id="bill_month" value="" placeholder="2016-05" onchange="search()"/>
            <div class="now_date">
                <p>本月应还</p>
                <p class="money" id="money"></p>
                <p id="refund_date"></p>
            </div>
        </div>
        <a class="bill_list"  href="{{url('bills')}}">
            <div class="left">
                <p>
                    <span id="title"></span>
                    <span id="money"></span>
                </p>
                <p>
                    <span id="num"></span>
					<span id="status"></span>
                </p>
            </div>
            <div class="right"><i class="iconfont icon-dayuhao"></i></div>
        </a>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script>
        var status=null;
        $().ready(function(){
            var myDate = new Date();
            var year=myDate.getFullYear();
            var month=myDate.getMonth()+1;
            if(month<10){
                month='0'+month;
            }
            $('.bill_list').hide();
            $.ajax({
                type: "POST",
                url: "bill",
                data: {
                    data:year+month
                },
                success: function(res) {
                    if(res.refund){
                        $('#money').html(res.refund.money)
                        $('#refund_date').html("还款时间："+res.refund.refund_date);
                        $('#title').html(res.refund.title);
                        $('#num').html('第'+res.refund.num+'/'+res.refund.nums+'期');
                        if(res.refund.status==0){
                            status='待付款';
                        }
                        else if(res.refund.status==1){
                            status='已付款'
                        }
                        else{
                            status='逾期'
                        }
                        $('#status').html(status);
                        $('.bill_list').show();
                    }
                    else{
                        $('#money').html(0)
                        $('#refund_date').html('');
                        $('.bill_list').hide();
                    }
                },
                error:function(err){
                    console.log(err);
                }
            });
        })
		function search(){
			var data=$("#bill_month").val();
			data=data.replace('-', '')
			$.ajax({
				type: "POST",
				url: "bill",
				data: {
					data:data
				},
				success: function(res) {
					if(res.refund){
						$('#money').html(res.refund.money)
						$('#refund_date').html("还款时间："+res.refund.refund_date);
						$('#title').html(res.refund.title);
						$('#num').html('第'+res.refund.num+'/'+res.refund.nums+'期');
                        if(res.refund.status==0){
                            status='代付款';
                        }
                        else if(res.refund.status==1){
                            status='已付款'
                        }
                        else{
                            status='逾期'
                        }
                        $('#status').html(status);
						$('.bill_list').show();
					}
					else {
                        alert(res.msg);
                        $('#money').html(0)
                        $('#refund_date').html(data);
                        $('.bill_list').hide();
                    }
				},
				error:function(err){
					console.log(err);
				}
			});
		}
	</script>
</html>
