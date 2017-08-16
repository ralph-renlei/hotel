var myScroll,
    pullUpEl, pullUpOffset,
    generatedCount = 0;

function pullUpAction() {
    var p2 = 2;
    var p = $('#pullUp').attr('data');

    if(parseInt(p) > 1) {
        if(p2 == p) {
            return;
        } else {
            $.post(URL, {
                    'area': area,
                    'city':city,
                    'pro':pro,
                    'price': price,
                    'unit': unit,
                    'page': p
                },
                function(res) {
                    if(res.data) {
                        $('#thelist').html(res.data.html);
                        myScroll.refresh();
                    } else {
                        $('#thelist').html('');
                    }
                    $('#pullUp').attr('data', res.data.next_page);
                    $('#pullUp').attr('data-total', res.data.total_page);
                    if(res.next_page == 0) {
                        pullUpEl.querySelector('.pullUpLabel').innerHTML = "没有更多了...";
                        pullUpEl.querySelector('.pullUpIcon').style.display = "none";
                    }
                },'json');
        }
        p2 = p;
        myScroll.refresh();
    } else {
        pullUpEl.querySelector('.pullUpLabel').innerHTML = '没有更多了...';
        pullUpEl.querySelector('.pullUpIcon').style.display = "none";

    }
}
//筛选的时候
function listAction() {
    var p = $('#pullUp').attr('data');
    $.post(URL, {
            'price': price,
            'unit': unit,
            'page': p,
            'area': area,
            'city':city,
            'pro':pro
        },
        function(res) {
            if(res.data) {
                if(res.data.next_page > 2){
                    $('#thelist').append(res.data.html);
                }else {
                    $('#thelist').html(res.data.html);
                }
                console.log(res.data.next_page);
                myScroll.refresh();
            } else {
                $('#thelist').html(' ');
            }
            $('#pullUp').attr('data', res.data.next_page);
            $('#pullUp').attr('data-total', res.data.total_page);
            if(res.data.next_page == 0) {
                pullUpEl.querySelector('.pullUpLabel').innerHTML = "没有更多了...";
                pullUpEl.querySelector('.pullUpIcon').style.display = "none";
            }
        },'json');
    myScroll.refresh();
    return false;
}

/**
 * 初始化iScroll控件
 */
function loaded() {
    pullUpEl = document.getElementById('pullUp');
    pullUpOffset = pullUpEl.offsetHeight;
    if($("#pullUp").attr("data-total") <= 2) {
        pullUpEl.querySelector('.pullUpLabel').innerHTML = '没有更多了...';
        pullUpEl.querySelector('.pullUpIcon').style.display = "none";
    }
    myScroll = new iScroll('wrapper', {
        scrollbarClass: 'myScrollbar',
        useTransition: false,
        onRefresh: function() {
            if(pullUpEl.className.match('loading')) {
                pullUpEl.className = '';
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '正在加载更多...';
            }
        },
        onScrollStart: function() {
            var next_page = $('#pullUp').attr('data');
            next_page = parseInt(next_page);
            var p1 = $('#pullUp').attr('data-total');
            if(parseInt(next_page) > parseInt(p1)) {
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '没有更多了...';
                pullUpEl.querySelector('.pullUpIcon').style.display = "none";
            } else if(parseInt(next_page) == 0) {
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '没有更多了...';
                pullUpEl.querySelector('.pullUpIcon').style.display = "none";
            } else {
                pullUpEl.querySelector('.pullUpIcon').style.display = "block";
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '正在加载更多...';
            }
        },
        onScrollEnd: function() {
            var next_page = $('#pullUp').attr('data');
            next_page = parseInt(next_page);
            var p1 = $('#pullUp').attr('data-total');
            if(parseInt(next_page) != 0 && next_page <= parseInt(p1)) {
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '正在加载更多...';
                pullUpEl.querySelector('.pullUpIcon').style.display = "block";
                if(this.y == this.maxScrollY) {
                    listAction();
                }
            }
            if(parseInt(next_page) == 0) {
                pullUpEl.querySelector('.pullUpLabel').innerHTML = '没有更多了...';
                pullUpEl.querySelector('.pullUpIcon').style.display = "none";
            }
        }
    });
}
document.addEventListener('DOMContentLoaded', loaded, false);