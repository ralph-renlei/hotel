@if(count($list)>0)
@foreach($list as $item)
    <div class="interval_bar clearfix">
        <div class="left">
            <p>{{ $item->card_name }}</p>
            <p>{{ date('Y-m-d H:i:s',$item->add_time) }}</p>
        </div>
        <div class="right">
            <p>{{ $item->pay_fee }}</p>
            @if($item->pay_status==1)
                <p>已付款</p>
            @else
                <p>未付款</p>
            @endif
        </div>
    </div>
@endforeach
@else
    <div class="interval_bar clearfix">
        <div class="left">
            <p>抱歉，暂无数据</p>
        </div>
    </div>
@endif