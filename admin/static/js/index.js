// 冲突时显示
$(function(){
  // 控制多选框显示
   var open = false;
    $('.selectClick').click(function(){
        if(!open){
          $('.bootstrap-select.btn-group .dropdown-menu').css("display","block");
          open = true;  
        }
        else{
             $('.bootstrap-select.btn-group .dropdown-menu').css("display","none");
          open = false; 
        }
    });

    // 登录退出显示
    var show = false;
    $('.mainHeader_user').click(function(){
        if(!show){
          $('.no-imageposition').css("display","block");
          show = true;
        }
        else{
           $('.no-imageposition').css("display","none");
           show = false;
        }
    })
});
// 获取选中值
  function getOptoions() {
      var select = document.getElementById("maxOption2 search_source");
      var str = [];
      for(var i=0;i<select.length;i++){
          if(select.options[i].selected){
                  str.push(select[i].value);
              }
          }
         return str;
  }
