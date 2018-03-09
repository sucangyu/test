<!DOCTYPE HTML> 
<html> 
    <head> 
    <meta charset="utf-8" />
        <meta charset="gb2312"> 
        <title>HTML5教程之本地存储SessionStorage</title> 
        <script type="text/javascript"> 
                window.onload = function() 
                { 
                        alert("当你关闭此页面或者关闭浏览器的时候，sessionStorage中保存的数据才会消失，也就是说重新打开此页面的时候，点击获取数据，将不会显示任何数据，刷新页面无效。\r\n由此可以证明，sessionStorage的生命周期为，某个用户浏览网站时，从进入到离开的这段时间。") 
                         
                        //首先获得body中的3个input元素 
                        var msg = document.getElementById("msg"); 
                        var getData = document.getElementById("getData"); 
                        var setData = document.getElementById("setData"); 
                         
                        setData.onclick = function()//存入数据 
                        { 
                                if(msg.value) 
                                { 
                                        sessionStorage.setItem("data", msg.value); 
                                        alert("信息已保存到data字段中"); 
                                } 
                                else 
                                { 
                                        alert("信息不能为空"); 
                                } 
                        } 
                         
                        getData.onclick = function()//获取数据 
                        { 
                                var msg = sessionStorage.getItem("data"); 
                                if(msg) 
                                { 
                                        alert("data字段中的值为：" + msg); 
                                } 
                                else 
                                { 
                                        alert("data字段无值！"); 
                                } 
                        } 
                } 
        </script> 
    </head> 
     
    <body> 
        <input id="msg" type="text"/> 
        <input id="setData" type="button" value="保存数据"/> 
        <input id="getData" type="button" value="获取数据"/> 
    </body> 
</html> 