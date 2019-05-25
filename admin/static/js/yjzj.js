$(function () {
    var num = 3;
    $("#add-div").on("click", function () {
        num = num + 1;
        var tr = '<tr id="add-div">\n' +
            '                        <td><span class="form-tit">表单项-'+num+'：</span></td>\n' +
            '                        <td>\n' +
            '                            <span class="td-span">标签</span>\n' +
            '                            <input type="text" placeholder="您的电话" class="form-control width120">\n' +
            '                        </td>\n' +
            '                        <td>\n' +
            '                            <span class="td-span">样式</span>\n' +
            '                            <select class="form-control width120">\n' +
            '                                <option>多行文本</option>\n' +
            '                                <option>单行文本</option>\n' +
            '                            </select>\n' +
            '                        </td>\n' +
            '                        <td>\n' +
            '                            <span class="td-span">提示</span>\n' +
            '                            <input type="text" class="tip-in">\n' +
            '                        </td>\n' +
            '                        <td>\n' +
            '                            <span class="td-span">必填</span>\n' +
            '                            <select class="form-control width120">\n' +
            '                                <option>是</option>\n' +
            '                                <option>否</option>\n' +
            '                            </select>\n' +
            '                            <button class="close-del">X</button>\n' +
            '                        </td>\n' +
            '                    </tr>';
        $("#tbody").append(tr);
    });
    //点击删除
    $("#tbody").on("click","tr td button",function(){
        $("#add-div").remove();
        console.log("删除了")
    });
});