<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $item->store_name }}</title>
</head>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<style type="text/css">
    html,
    body {
        width: 100%;
        height: 100%;
    }
    * {
        margin: 0px;
        padding: 0px;
    }
    body,
    button,
    input,
    select,
    textarea {
        font: 12px/16px Verdana, Helvetica, Arial, sans-serif;
    }
    p {
        width: 603px;
        padding-top: 3px;
        overflow: hidden;
    }
    .btn {
        width: 142px;
    }
    #container {
        min-width: 600px;
        min-height: 767px;
    }
</style>
<script>
    var LAT = "{{ $item->lat }}";
    var LNG = "{{ $item->lng }}";
</script>
<body>
<div id="container" style="width:100%; height:100%"></div>
</body>
<script type="text/javascript">
    var myLatlng = new qq.maps.LatLng(LAT, LNG);
    var map = new qq.maps.Map(document.getElementById("container"), {
        // 地图的中心地理坐标。
        center: myLatlng,
        zoom: 14,
    });
    var anchor = new qq.maps.Point(0, 39),
            size = new qq.maps.Size(42, 68),
            origin = new qq.maps.Point(0, 0),
            icon = new qq.maps.MarkerImage(
                    "http://open.map.qq.com/doc/img/nilt.png",
                    size,
                    origin,
                    anchor
            );
    //设置Marker阴影图片属性，size是图标尺寸，该尺寸为显示图标的实际尺寸，origin是切图坐标，该坐标是相对于图片左上角默认为（0,0）的相对像素坐标，anchor是锚点坐标，描述经纬度点对应图标中的位置
    var anchorb = new qq.maps.Point(3, -30),
            sizeb = new qq.maps.Size(42, 11),
            origin = new qq.maps.Point(0, 0),
            iconb = new qq.maps.MarkerImage(
                    "http://open.map.qq.com/doc/img/nilb.png",
                    sizeb,
                    origin,
                    anchorb
            );
    var marker = new qq.maps.Marker({
        map: map,
        position: myLatlng
    });
//    marker.setIcon(icon);
//    marker.setShadow(iconb);
</script>
</html>