//获取url参数
function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}

/**
 * 显示弹出框
 * @return
 */
function Alert(msg,callback){
	layer.alert(msg,{
		title: '系统提示',
		closeBtn:0
	},function(){
		if (typeof callback === "function"){
		   callback();
        } else {
        	layer.closeAll('dialog');
        }
	});
}

/**
 * 显示询问框
 * @return
 */
function Confirm(msg,rdirectFun){
	layer.confirm(msg, {
	  btn: ['确定','取消'],
	  title: '系统提示',
	  closeBtn:0
	}, function(){
		rdirectFun();
	}, function(){
		closeAll();
	});
}


/**
 * 显示加载层
 * @return
 */
function Loading(){
	layer.load(0, {shade: 0.3});
}

function CloseLoading(){
	closeAll();
}

function closeAll(){
	layer.closeAll();
}

/**
 * 显示视频
 */
function Video(src){
	layer.open({
		  type: 2,
		  title: false,
		  area: ['630px', '355px'],
		  shade: 0.8,
		  closeBtn: 0,
		  shadeClose: true,
		  content: src
	});
}


/**
 * 显示图片
 */
function Imager(id){
	layer.photos({
		  photos:id,
		  shade: 0.2,
		  closeBtn:2,
		  shadeClose:true
	});
}

/**
 * 弹出表单页面 成功回调函数 saveSuccess
 * @param title
 * @param src
 * @param width
 * @param height
 * @return
 */
function openModelWindow(title,src,width,height){
	var index = layer.open({
	      type: 2,
	      shade: 0.1,
	      title: title,
	      shadeClose: true,
		  shift :2,
	      maxmin: false, //开启最大化最小化按钮
	      area: [width, height],
	      content: src,
	      yes:function(index, layero){
			var body = layer.getChildFrame('body', index);
		    var iframeWin = window[layero.find('iframe')[0]['name']];
		    iframeWin.saveSuccess();
		},
   });
   return index;
}


/**
 * 弹出表单页面 成功回调函数 saveSuccess
 * @param title
 * @param src
 * @param width
 * @param height
 * @return
 */
function openModelWindowTwo(title,src,width,height){
	var index = layer.open({
		type: 2,
		shade: 0.5,
		closeBtn:0,
		title: title,
		shadeClose: false,
		shift :2,
		maxmin: false, //开启最大化最小化按钮
		area: [width, height],
		content: src,
		yes:function(index, layero){
			var body = layer.getChildFrame('body', index);
			var iframeWin = window[layero.find('iframe')[0]['name']];
			iframeWin.saveSuccess();
		},
	});
	return index;
}




/**
 * 弹出表单页面 成功回调函数 saveSuccess
 * @param title
 * @param src
 * @param width
 * @param height
 * @return
 */
function pageLayer(src,width,height){
	var index = layer.open({
	      type: 2,
	      shade: 0.8,
	      closeBtn:0,
	      title: false,
	      shadeClose: true,
		  shift :2,
		  shade: 0.1,
	      maxmin: false, //开启最大化最小化按钮
	      area: [width, height],
	      content: src,
	      yes:function(index, layero){
			var body = layer.getChildFrame('body', index);
		    var iframeWin = window[layero.find('iframe')[0]['name']];
		    iframeWin.saveSuccess();
		},
   });
   return index;
}


/**
 * 设置cookie
 * @return
 */
function setCookie(name,value,minute,domain) {
    if ( minute > 0 ) {
        var exp  = new Date();
        exp.setTime(exp.getTime() + minute*60*1000);
        document.cookie = name + "="+ escape (value) + ";domain=" + domain + ";expires=" + exp.toGMTString()+";path=/";
    } else {
        document.cookie = name + "="+ escape (value) + ";domain=" + domain + ";path=/";
    }
}

/**
 * 获取cookie
 * @return
 */
function getCookie(objName){
    var arrStr = document.cookie.split("; ");
    for(var i = 0;i < arrStr.length; i++){
        var temp = arrStr[i].split("=");
        if(temp[0] == objName) return decodeURI(temp[1]);
    }
}


/*
 * 验证0-100的整数
 */

function verificationNumber (value) {
	var testReturn = true;
	var reg=/(^[1-9][0-9]$|^[0-9]$|^100$)/;
	if(reg.test(value)){
		testReturn = true;
	}else{
		testReturn = false;
	}
	return testReturn;
};

/*
 * 验证6-16字符串
 */

function verificationChar16 (value) {
	console
	var testReturn = true;
	var reg = /^[a-zA-Z]\w{3,15}$/ig;
	if(reg.test(value)){
		testReturn = true;
	}else{
		testReturn = false;
	}
	return testReturn;
};




$(".mainBox").css({
	'minHeight': $('.navLeftTab').height()+200
  });

// $(".mainBox").height($('.navLeftTab').height()+200);
$(".mainBox").width($(window).width() - 255);
$(document).ready(function(){
	$(".admin_nav").niceScroll({cursorborder:"",cursorcolor:"#ffffff",boxzoom:false});
	$(".navLeftTab .item .tit").each(function(){
		$(this).click(function(){
			if($(this).parent(".item").hasClass('current')){
				$(this).parent(".item").removeClass('current');
			} else {
				$(this).parent(".item").addClass('current');
			}
		});
	});
});

window.onresize = function(){
	$(".mainBox").css({
	'minHeight': $('.navLeftTab').height()+200
  });
  $(".mainBox").width($(window).width() - 255);
}

// 附件
function loadFile(el){
    $("#filename").css('display','none');
    var files = el.files;
    for(var i=0; i< files.length; i++){
        var fileName = files[i].name;
        $("#filename2").append(fileName+'<span>,&nbsp&nbsp&nbsp</span>');
    }

}

function loadFilepaper(el){
    $("#filename3").css('display','none');
    var files = el.files;
    for(var i=0; i< files.length; i++){
        var fileName = files[i].name;
        $("#filename4").append(fileName+'<span>,&nbsp&nbsp&nbsp</span>');
    }

}
