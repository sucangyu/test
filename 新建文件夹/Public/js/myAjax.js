/**
 * Created by Administrator on 2017/7/26.
 */
// 修改指定表的指定字段值
function changeTableVal(table,id_name,id_value,field,obj)
{
    var src = "";
    if($(obj).attr('src').indexOf("cancel.png") > 0 )
    {
        src = base_url+'/Public/imgs/yes.png';
        var value = 1;

    }else{
        src = base_url+'/Public/imgs/cancel.png';
        var value = 0;
    }
    $.ajax({
        // url:$upURL+"?table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field+'&value='+value,
        url:base_url+"/index.php/Admin/Index/changeTableVal?table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field+'&value='+value,
        success: function(data){
            $(obj).attr('src',src);
        }
    });
}

// 修改指定表的排序字段
function updateSort(table,id_name,id_value,field,obj)
{
    var value = $(obj).val();
    $.ajax({
        url:base_url+"/index.php/Admin/Index/changeTableVal?table="+table+"&id_name="+id_name+"&id_value="+id_value+"&field="+field+'&value='+value,
        success: function(data){
            layer.msg('更新成功', {icon: 1});
        }
    });
}

/**
 * 删除
 * @returns {void}
 */
function del_fun(del_url)
{
    if(confirm("确定要删除吗?"))
        location.href = del_url;
}

/**
 * 获取多级联动的商品分类
 */
function get_category(id,next,select_id){
    var url = base_url+'/index.php/Home/Api/get_category/parent_id/'+ id;
    $.ajax({
        type : "GET",
        url  : url,
        error: function(request) {
            alert("服务器繁忙, 请联系管理员!");
            return;
        },
        success: function(v) {
            v = "<option value='0'>请选择商品分类</option>" + v;
            $('#'+next).empty().html(v);
            (select_id > 0) && $('#'+next).val(select_id);//默认选中
        }
    });
}

