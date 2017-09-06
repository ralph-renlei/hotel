@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            @include('menu')
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">电量统计
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <form class="form-inline" action="{{ url('/admin/shop/power_count') }}" method="get">
                                <div class="form-group">
                                    <label class="label_left">查看每天房间房间用电量{{$hotel_name}}</label>
                                    <input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="end" id="start" value="">
                                    <input type="hidden" id="power_str" value="{{$power_str}}"/>
                                    <input type="hidden" id="room_str" value="{{$room_str}}"/>
                                </div>
                                <button type="submit" class="btn btn-default search_bottom">搜索</button>
                            </form>
                        </div>
                            <script type="text/javascript" src="{{asset('/power/jQuery.js')}}"></script>
                            <script type="text/javascript" src="{{asset('/power/jqplot.js')}}"></script>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    var power_str = $('#power_str').val();
                                    var room_str = $('#room_str').val();
                                    var power =  power_str.split(",");
                                    for (var i = 0; i < power.length; i++) {
                                        parseFloat(power[i]);
                                    };
                                    var room = room_str.split(",");
//                                    for (var m = 0; m < power.length; m++) {
//                                        parseFloat(room[m]);
//                                    };
                                    var data = [power];
                                    var data_max = 30; //Y轴最大刻度
                                    var line_title = ["A","B"]; //曲线名称
                                    var y_label = "每日用电量"; //Y轴标题
                                    var x_label = "日期"; //X轴标题
                                    var x = room; //定义X轴刻度值
                                    var title = "房间用电量统计图"; //统计图标标题
                                    j.jqplot.diagram.base("chart1", data, line_title, "房间用电量统计图", x, x_label, y_label, data_max, 1);
                                    j.jqplot.diagram.base("chart2", data, line_title, "房间用电量统计图", x, x_label, y_label, data_max, 2);
                                });
                            </script>
                            <div id="chart1"></div>
                            <div id="chart2"></div>
                            <div style="text-align:center;margin:50px 0; font:normal 14px/24px 'MicroSoft YaHei';">
                    </div>
                </div>
            </div>
        </div>
@endsection