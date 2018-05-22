<?php
echo 'hello world!' ;
 public static void main(String[] args) {
        echo "公众号：Java3y：" + sum(100);
    }

    /**
     *
     * @param n 要加到的数字，比如题目的100
     * @return
     */
    public static int sum(int n) {

        //如果递归出口为4，(1+2+3+4)
        if (n == 4) {
            return 10;
        } else {
            return sum(n - 1) + n;
        }
    }
//phpinfo() ;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>
