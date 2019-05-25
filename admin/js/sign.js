
var token = "zhimakaihua";

function getSign(method,timestamp) {



    var sign = $.md5(method+timestamp+token);



    return sign;
}