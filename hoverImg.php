	
<!DOCTYPE html>  
<html>  
    <head>  
        <meta charset="UTF-8">  
        <title>鼠标移上图片图片放大</title>  
        <style type="text/css">  
            div{  
                width: 300px;  
                height: 300px;  
                border: #000 solid 1px;  
                margin: 50px auto;  
                overflow: hidden;  
            }  
            div img{  
            	width: 100%;
            	height: 100%;
                cursor: pointer;  
                transition: all 0.6s;  
            }  
            div img:hover{  
                transform: scale(1.2);  
            }  
        </style>  
    </head>  
    <body>  
        <div>  
            <img src="helloweba.png" />  
        </div>  
    </body>  
</html>