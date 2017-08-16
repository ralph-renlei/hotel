<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>赛高娱乐</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t=').time() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dropload.css') }}" />
    <script type="text/javascript">
        var LOCATE_URL = "{{ url('locate') }}";
        var URL = "{{ url('store') }}";
        var QQ_KEY = '2EEBZ-XZVKI-3K3GP-5LWGX-QNSS2-VNBFF';
        var DF_CITY = '西安';
        var DF_LAT = '34.34127';
        var DF_LNG = '108.93984';
        var LAT = "{{ $lat }}";
        var LNG = "{{ $lng }}";
        var UID = "{{ $uid }}";
        var OPENID = "{{ $openid }}";
        var SITE = "{{ url() }}";
    </script>
</head>
<style type="text/css">
    body {
        width: 100%;
        height: 100%;
    }
    .slideout-menu {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 0;
        width: 256px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        display: none;
    }
    .slideout-panel {
        position: relative;
        z-index: 1;
    }
    .slideout-open,
    .slideout-open body,
    .slideout-open .slideout-panel {
        overflow: hidden;
    }
    .slideout-open .slideout-menu {
        display: block;
    }
</style>
<body>
<!-- 侧滑导航根容器 -->
<div>
    <!-- 菜单容器 -->
            <aside id="menu">
                <!-- 菜单具体展示内容 -->
                <div class="main_info">
                    <div class="info_on clearfix">
                        <a href="{{ url('user') }}" class="clearfix"><i class="iconfont icon-shezhi"></i></a>
                        <div class="mid clearfix">
                            <img src="{{ $user->avatar }}"  onerror="this.src='{{ asset('img/avatar.png') }}'" class="mid_left avatar" />
                            <div class="mid_right right_top clearfix">
                                <span class="username">{{ $user->nickname }}</span>
                                <div class="wg">
                                    @if($user->vip)
                                        <i class="iconfont icon-dengji-copy"></i>
                                    @elseif($user->role == 'sale')
                                        <i class="iconfont icon-dengji-copy"></i>
                                    @else
                                        <i class="iconfont icon-dengji-copy vip_grey"></i>
                                    @endif
                                    <p>{{ $user->level }}</p>
                                </div>
                            </div>
                        </div>

                        @if(empty($uplevel))
                            <p class="small_text mid_p">已经是最高级别了</p>
                        @else
                            <p class="small_text mid_p">还差<span id="exp_value">{{ $uplevel['point'] }}</span>个经验值升级到<span id="level_text">{{ $uplevel['title'] }}</span></p>
                        @endif
                        <div class="experience_bar clearfix">
                            <div class="">
                                <p class="bar_wrap"></p>
                                <p class="bar"></p>
                            </div>
                            <p class="small_text jingyanzhi">{{ $user->point }}/{{ $level['max'] }}</p>
                        </div>
                    </div>
                    <div class="bottom">
                        <span>余额</span>
                        <span>{{ $user->money }}</span>
                        <span class="tixian_btn"><a href="{{ url('deposit') }}">提现</a></span>
                    </div>
                </div>
                <!--详情-->
                <div class="personbar_wrap">
                    <a href="{{ url('profile') }}">
                        <div class="person_bar">
                            <div class="person_bar_on bar_line">
                                <i class="iconfont icon-gerenziliao" style="color: #4f95ff;"></i>
                                <span>个人资料</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('super') }}">
                        <div class="person_bar">
                            <div class="person_bar_on bar_line">
                                <i class="iconfont icon-m-members" style="color: #eb3536;"></i>
                                <span style="color:red">我的超级会员</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('qrcode') }}">
                        <div class="person_bar">
                            <div class="person_bar_on bar_line">
                                <i class="iconfont icon-tuiguang" style="color: #eb3536;"></i>
                                <span>成为推广员</span>
                                <i class="iconfont icon-erweima"></i>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('affiliate') }}">
                        <div class="person_bar">
                            <div class="person_bar_on">
                                <i class="iconfont icon-rongyu" style="color: #15c116;"></i>
                                <span>我的推广</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('cash') }}">
                        <div class="person_bar cashback">
                            <div class="person_bar_on">
                                <i class="iconfont icon-xiaofei01" style="color: #ffab4f;"></i>
                                <span>消费返现明细</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('money') }}">
                        <div class="person_bar">
                            <div class="person_bar_on bar_line">
                                <i class="iconfont icon-icon1" style="color: #0bc2af;"></i>
                                <span>交易明细</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('charge') }}">
                        <div class="person_bar chargerecord">
                            <div class="person_bar_on">
                                <i class="iconfont icon-tixianjilu" style="color: #f2b03d;"></i>
                                <span>充值记录</span>
                            </div>
                        </div>
                    </a>
                    <a>
                        <div class="person_bar">
                            <div class="person_bar_on bar_line">
                                <i class="iconfont icon-zuanshi" style="color: #2399dc;"></i>
                                <span>经验值</span>
                                <span class="red_text jingyan">{{ $user->point }}/{{ $level['max'] }}</span>
                            </div>
                        </div>
                    </a>
                    <a>
                        <div class="person_bar">
                            <div class="person_bar_on">
                                <i class="iconfont icon-vip" style="color: #fe6060;"></i>
                                <span>会员截止日期:</span>
                                @if(isset($vip))
                                <span class="red_text">{{ $vip->end_date }}</span>
                                @else
                                    <span class="red_text">未开通会员</span>
                                @endif
                                <a href="{{ url('vip/') }}" class="go_charge">去充值</a>
                            </div>
                        </div>
                    </a>
                </div>
    </aside>
    <!-- 主页面容器 -->

    <div id="panel">
        <div class="panel_mask"></div>
        <!-- 主页面标题 -->
        <header>
            <img src="{{ $user->avatar }}"  onerror="this.src='{{ asset('img/avatar.png') }}'" class="index_avatar toggle-button" />
        </header>
            <div>
                <!-- 主界面具体展示内容 -->
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="{{ asset('img/banner1.png') }}" /></div>
                        <div class="swiper-slide"><img src="{{ asset('img/banner2.png') }}" /></div>
                        <div class="swiper-slide"><img src="{{ asset('img/banner3.png') }}" /></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="nav">
                    <div class="classify">
                        <div class="classbox" id="ktv">
                            <span class="ktv_box"><i class="iconfont icon-ktv"></i></span>
                            <p>KTV</p>
                        </div>
                        <div class="classbox" id="bar">
                            <span class="jiuba_box"><i class="iconfont icon-jiuba"></i></span>
                            <p>酒吧</p>
                        </div>
                        <div class="classbox" id="path">
                            <span class="ye_box"><i class="iconfont icon-caozuo-yedian"></i></span>
                            <p>洗浴</p>
                        </div>
                        <div class="classbox" id="other">
                            <span class="qita_box"><i class="iconfont icon-qita"></i></span>
                            <p>其他</p>
                        </div>
                    </div>
                    <div class="input_wrap">
                        <i class="iconfont icon-search"></i>
                        <input type="text" name="storename" id="storename" value="" placeholder="请输入商家名称" />
                    </div>
                </div>
                <img src="{{ asset('img/loading.png') }}" class="loading_img"/>
                <div class="store_wrap">
                    <ul id="store_ul">
                        @include('mobile._item')
                    </ul>
                </div>
                <div class="tabbar">
                    <a href="{{ url('index') }}" style="color: #11b6f5;">
                        <i class="iconfont icon-shouyeshouye"></i>
                        <p>首页</p>
                    </a>
                    <a href="{{ url('service') }}">
                        <i class="iconfont icon-kefu"></i>
                        <p>客服</p>
                    </a>
                </div>
            </div>
    </div>
</div>
</body>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/swiper.jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/dropload.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/mobile.common.js?t='.time()) }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/slideout.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var URL = "{{ url('store') }}";
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70
    });

    $('.toggle-button').on('click', function() {
        slideout.toggle();
        if(!slideout.isOpen()){
            $("#panel").removeAttr("style");
        }
    });
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        loop: true,
    });

    $("#ktv").on('click', function() {
        var cate = 'ktv';
        muiAjax(cate);
    });
    $("#bar").on('click', function() {
        var cate = 'bar';
        muiAjax(cate);
    });
    $("#path").on('click', function() {
        var cate = 'path';
        muiAjax(cate);
    });
    $("#other").on('click', function() {
        var cate =  'other';
        muiAjax(cate);
    });

    function muiAjax(cate) {
        $(".loading_img").show();
        $('#store_ul').empty();
        page = 1;
        $.ajax(URL, {
            data: {
                page: page,
                cate: cate,
                keyword:$("#storename").val(),
                lat: LAT,
                lng: LNG
            },
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                $(".loading_img").hide();
                if(data.code>0){
                    $('#store_ul').html(data.data);
                    if(data.code==2){
                        $('.more').hide();
                    }else{
                        $('.more').show();
                    }
                }
            },
            error: function(xhr, type, errorThrown) {
                console.log(type);
            }
        });
    }

    // 轮播图
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        loop: true,
        autoplay: 1000
    });
    var page = 1;
    	getLocation();
    		$('.store_wrap').dropload({
    			scrollArea: window,
    			loadDownFn: function(me) {
    				page++;
    				$.ajax({
    					type: 'post',
    					url: URL,
    					dataType: 'json',
    					data: {
    						page: page,
    						keyword: $("#storename").val(),
    						lat: LAT,
    						lng: LNG
    					},
    					success: function(res) {
                            if(res.code == 1){
                                $('#store_ul').append(res.data);
                            }
    						$(".dropload-down").remove();
    						if(res.data.length < 1) {
    							me.lock();
    							me.noData();
    						}
    						me.resetload();
    					},
    					error: function(xhr, type) {
    						alert('Ajax error!');
    						me.resetload();
    					}
    				});
    			}
    		});
</script>
</html>