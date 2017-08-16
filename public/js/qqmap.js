/**
 * Created by Jian on 2016/12/21.
 */
if($('#map').length>0){
    window.onload = loadScript;
}

var geocoder,map,marker = null,markers = [];
var init = function() {
    var lat = $('#lat').val()?$('#lat').val():34.34127;
    var lng = $('#lng').val()?$('#lng').val():108.93984;

    var center = new qq.maps.LatLng(lat,lng);
    map = new qq.maps.Map(document.getElementById('map'),{
        center: center,
        zoom: 15
    });

    var marker = new qq.maps.Marker({
        map:map
    });
    marker.setPosition(center);

    //设置Poi检索服务，用于本地检索、周边检索
    searchService = new qq.maps.SearchService({
        //检索成功的回调函数
        complete: function(results) {
            //设置回调函数参数
            var pois = results.detail.pois;
            var infoWin = new qq.maps.InfoWindow({
                map: map
            });
            var latlngBounds = new qq.maps.LatLngBounds();
            for (var i = 0, l = pois.length; i < l; i++) {
                var poi = pois[i];
                //扩展边界范围，用来包含搜索到的Poi点
                latlngBounds.extend(poi.latLng);

                (function(n) {
                    var marker = new qq.maps.Marker({
                        map: map
                    });
                    marker.setPosition(pois[n].latLng);

                    marker.setTitle(i + 1);
                    markers.push(marker);
                    qq.maps.event.addListener(marker, 'click', function() {
                        infoWin.open();
                        infoWin.setContent('<div style="width:280px;height:100px;">' + '名称为：' + pois[n].name + '，POI的地址为：' + pois[n].address + '</div>');
                        infoWin.setPosition(pois[n].latLng);
                        $('#lat').val(pois[n].latLng.lat);
                        $('#lng').val(pois[n].latLng.lng);
                    });
                })(i);
            }
            //调整地图视野
            map.fitBounds(latlngBounds);
        },
        //若服务请求失败，则运行以下函数
        error: function() {
            alert("出错了。");
        }
    });
}

function loadScript() {
    //创建script标签
    var script = document.createElement("script");
    //设置标签的type属性
    script.type = "text/javascript";
    //设置标签的链接地址
    script.src = "http://map.qq.com/api/js?v=2.exp&callback=init";
    //添加标签到dom
    document.body.appendChild(script);
}

//清除地图上的marker
function clearOverlays(overlays) {
    var overlay;
    while (overlay = overlays.pop()) {
        overlay.setMap(null);
    }
}
//设置搜索的范围和关键字等属性
function searchKeyword() {
    var keyword = document.getElementById("text_key").value;
    var region = document.getElementById("city").value;
    var pageIndex = 1;
    var pageCapacity = 10;
    clearOverlays(markers);
    //根据输入的城市设置搜索范围
    searchService.setLocation(region);
    //设置搜索页码
    searchService.setPageIndex(pageIndex);
    //设置每页的结果数
    searchService.setPageCapacity(pageCapacity);
    //根据输入的关键字在搜索范围内检索
    searchService.search(keyword);
}

function codeAddress() {
    var address = document.getElementById("text_key").value;
    geocoder.getLocation(address);
    geocoder.setComplete(function(result) {
        map.setCenter(result.detail.location);
        var marker = new qq.maps.Marker({
            map: map,
            position: result.detail.location
        });
        $('#lat').val(result.detail.location.lat);
        $('#lng').val(result.detail.location.lng);
        //点击Marker会弹出反查结果
        qq.maps.event.addListener(marker, 'click', function() {
            alert("坐标地址为： " + result.detail.location);
        });
    });
    geocoder.setError(function() {
        alert("出错了，请输入正确的地址！");
    });
}

function codeLatLng() {
    //获取经纬度数值   按照,分割字符串 取出前两位 解析成浮点数
    var input = document.getElementById("latLng").value;
    var latlngStr = input.split(",",2);
    var lat = parseFloat(latlngStr[0]);
    var lng = parseFloat(latlngStr[1]);
    var latLng = new qq.maps.LatLng(lat, lng);
    //调用信息窗口
    var info = new qq.maps.InfoWindow({map: map});
    //调用获取位置方法
    geocoder.getAddress(latLng);
}

