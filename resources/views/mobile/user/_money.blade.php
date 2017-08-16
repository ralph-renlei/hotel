@if(count($list)>0)
@foreach($list as $item)
    <div class="interval_bar clearfix">
        <div class="left">
            <p>{{ $item->title }}</p>
            <p>{{ $item->created_at }}</p>
        </div>
        <div class="right">
            @if($item->type==1)
                <p>+{{ $item->money }}</p>
            @else
                <p>-{{ $item->money }}</p>
            @endif
            <p>成功</p>
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