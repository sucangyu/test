<?php
header("content-type:text/html;charset=utf-8;");
var_dump($_POST);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form method="post" action="select.php">
            <select id="select6" name="tags[]" class="form-control select2-hidden-accessible" style="width: 100%" data-placeholder="请输入或选择标签" multiple="multiple" tabindex="-1" aria-hidden="true">
                <option value="aa" data-select2-tag="true" selected="">aa</option>
                <option value="bb" data-select2-tag="true" selected="">bb</option>
                <option value="cc" data-select2-tag="true" selected>cc</option>
                <option value="dd" data-select2-tag="true">dd</option>
            </select>

            <!-- <select style="width: 100px;" id="pre" onchange="chg(this);" name="aa[]">
                <option value="aa">aa</option>
                <option value="bb">bb</option>
                <option value="cc">cc</option>
                <option value="dd">dd</option>
            </select> -->
            <input type="submit" name="" value="tt"/>
        </form>
        

    </body>
   
</html>