@if(count($list)>0)
    @foreach($list as $item)
        <div class="interval_bar clearfix">
            <i class="iconfont icon-shangpu"></i>
            <div class="left s_name">
                <p>{{ $item->store_name }}</p>
                <p>
                    <span>返现金额</span>
                    <span class="cash_money">{{ $item->cashback }}</span>
                </p>
            </div>
            <div class="right s_operate">
                <p class="bash_date">{{ $item->created_at }}</p>
                @if($item->status==0)
                    <p class="bash_state">审核中</p>
                @elseif($item->status==1)
                    <p class="bash_state">成功</p>
                @elseif($item->status==-1)
                    <p class="bash_state">已驳回</p>
                @endif
            </div>
            @if($item->status==-1)
                <a href="{{ url('cash/'.$item->id) }}"><i class="iconfont icon-jiantou s_jiantou"></i></a>
            @endif
        </div>
    @endforeach
@else
    <div class="interval_bar clearfix">
        <i class="iconfont icon-shangpu"></i>
        <div class="left s_name">
            <p>抱歉，暂无数据</p>
        </div>
    </div>
@endif