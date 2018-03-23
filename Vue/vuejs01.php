<!DOCTYPE html>
<html>
<head>
	<title>vuejs练习</title>
<script type="text/javascript" src="vue.js"></script>
<style type="text/css">

</style>


</head>
<body>
<div id="app-6">
  <p>{{ message }}</p>
  <input v-model="message">
</div>

<script>
    var app6 = new Vue({
      el: '#app-6',
      data: {
        message: 'Hello Vue!'
      }
    })

</script>


<div id="app">
    <input type="text" v-model="items.text" ref="count"/>
    <div  v-html="number"></div>
</div>
<script>
    new Vue({
        el: '#app',
        data: {
            number: '最多输入10字符',
            items: {
                text:'',
            },
        },
        watch:{   //watch()监听某个值（双向绑定）的变化，从而达到change事件监听的效果
            items:{
                handler:function(){
                    var _this = this;
                    var _sum = 10; //字体限制为100个
                    _this.$refs.count.setAttribute("maxlength",_sum);
                    _this.number= _sum- _this.$refs.count.value.length;
                },
                deep:true
            }
        }
    })
</script>
</body>
</html>