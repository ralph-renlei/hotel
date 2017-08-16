@if(count($list)>0)
    @foreach($list as $item)
        <li>
            <a href="{{ url('item/'.$item->id) }}">
                <div class="store_cell clearfix">
                    <div class="store_left">
                        <img src="{{ $item->logo }}" onerror="this.src='{{ asset('img/small.png') }}'"/>
                    </div>
                    <div class="store_right clearfix">
                        <div class="s_title clearfix">
                            <p class="store_name">{{ $item->store_name }}</p>
                            @if(isset($item->distance))<p class="grey_text distance">{{ $item->distance }}km</p>@endif
                        </div>
                        <p class="star_wrap">
                            @if((int)$item->star==1)
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif((int)$item->star==2)
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif((int)$item->star==3)
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif((int)$item->star==4)
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif((int)$item->star==5)
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                                <i class="iconfont icon-ds xuanzhong_ds"></i>
                            @endif
                        </p>
                        <div class="s_title grey_text clearfix">
                            <p>最低消费： <span class="red_text mini_charge">{{ $item->avgprice }}</span>元</p>
                            <p class="grey_text back_price">返<span class="red_text">&nbsp;{{ $item->cash }}</span></p>
                            @if($item->is_open==1)
                                <p class="status">营业中</p>
                            @else
                                <p class="status">停业中</p>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </li>
    @endforeach
@else
    <li>
        <a><div class="store_cell clearfix">
                <div class="store_left">
                    <img src="{{ asset('img/fail.png') }}"/>
                </div>
                <div class="store_right clearfix">
                    <div class="s_title">抱歉，暂无店铺</div>
                </div>
            </div>
        </a>
    </li>
@endif