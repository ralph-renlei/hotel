var position = position || {};

(function (pos, window) {

    var userCallBack = null, localUrl = '';

    // Baidu Map API callback
    window.render = function (position) {
        // callback
        userCallBack({
            province: position.result.addressComponent.province,
            city: position.result.addressComponent.city,
            district: position.result.addressComponent.district,
            lng: position.result.location.lng,
            lat: position.result.location.lat
        });
    };

    // Get psition for ip
    var ipPosition = function () {
        $.get(localUrl, function (data) {
            var position = $.parseJSON(data);
            // callback
            userCallBack({
                province: position.content.address_detail.province,
                city: position.content.address_detail.city,
                district: position.content.address_detail.district,
                lng: position.content.point.x,
                lat: position.content.point.y
            });
        });
    };

    // Geolocation API success callback
    var successCallback = function (position) {
        $.getScript("http://api.map.baidu.com/geocoder/v2/?ak=85400bd4684c77d862f92e84a283fa96&callback=render&location=" + position.coords.latitude + "," + position.coords.longitude + "&output=json&pois=0");
    };

    // Geolocation API error callback
    var errorCallback = function (error) {
        ipPosition();
    };

    // run
    pos.run = function (callback, url) {
        // set default value
        localUrl = url;
        userCallBack = callback;
        // check geo
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
                timeout: 3000
            });
        } else {
            ipPosition();
        }
    };

    return pos;
})(position, window);
