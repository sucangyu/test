<!DOCTYPE html >
<html>
<head>

<meta charset="UTF-8">
<style type="text/css">
h1 {
  text-align:center;
}

.jmTimer, .jmTicker, .jmMask {
  width:100px;
  height:100px;
  background-color:#00703c;
  position:relative;
}

.jmTimer {
  -webkit-border-radius: 100%;
  border-radius: 100%;
  width:98px;
  height:98px;
  overflow:hidden;
  border:1px solid #999999;
  transform: scale(2,2);
  -webkit-transform: scale(2,2);
  position:absolute;
  left:65px;
  top:130px;
  opacity:0.5;
}

.jmFace {
  -webkit-border-radius: 100%;
  border-radius: 100%;
  width:75px;
  height:75px;
  position:absolute;
  left:12.5%;
  top:12.5%;
  background-color:#ffffff;
  z-index:2;
}

.jmFace p {
  position:absolute;
  top:13px;
  left:0;
  right:0;
  text-align:center;
}

.jmTicker, .jmMask {
  position:absolute;
  width:50%;
  height:50%;
}

.jmTicker {
  -webkit-animation: jm-cycle 60s 1 linear; 
  animation: jm-cycle 60s 1 linear; 
  background-color:#b7d035;
  bottom:50%;
  left:50%;
  -webkit-border-top-right-radius: 100%;
  border-top-right-radius: 100%;
  transform-origin:0 100%;
  -webkit-transform-origin:0 100%;
  -webkit-transform-origin:0 100%;
  -webkit-transform: rotate(-90deg);
  transform:rotate(-90deg);
  z-index:1;
}


.jmMask {
  -webkit-animation: jm-cycle-jmMask 60s 1 linear; 
  animation: jm-cycle-jmMask 60s 10 linear; 
  -webkit-border-top-left-radius: 50px;
  background-color:#00703c;
  bottom:50%;
  left:0;
  z-index:1;
}


@-webkit-keyframes jm-cycle-jmMask {
   0% {
    -webkit-border-top-right-radius:0;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(0deg);
    -webkit-transform-origin:100% 100%;
    background-color:#00703c;
    width:50%;
    bottom:50%;
    left:0;
    z-index:1;
  }

  
   50% {
    -webkit-border-top-right-radius:0;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(0deg);
    -webkit-transform-origin:100% 100%;
    background-color:#00703c;
    width:50%;
    bottom:50%;
    left:0;
    z-index:1;
  }
   
  50.01% {
    -webkit-border-top-right-radius:0px;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(90deg);
    -webkit-transform-origin:100% 100%;
    background-color:#b7d035;
    width:50%;
    bottom:50%;
    left:0;
    z-index:0;
  }
    
  75% {
    -webkit-border-top-right-radius:0px;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(90deg);
    -webkit-transform-origin:100% 100%;
    background-color:#b7d035;
    width:50%;
    bottom:50%;
    left:0;
  }
    
  75.01% {
    -webkit-border-top-right-radius:100px;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(90deg);
    -webkit-transform-origin:50% 100%;
    background-color:#b7d035;
    width:100%;
    bottom:50%;
    left:0;
  }
    
  100% {
    -webkit-border-top-right-radius:100px;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(90deg);
    -webkit-transform-origin:50% 100%;
    background-color:#b7d035;
    width:100%;
    bottom:50%;
    left:0;
  }
}
   
@-webkit-keyframes jm-cycle {
  0% {
    -webkit-border-top-right-radius: 100px;
    -webkit-border-top-left-radius: 0;
    -webkit-transform: rotate(-90deg);
    -webkit-transform-origin:0 100%;
    width:50%;
  }

  25%  { 
    -webkit-border-top-right-radius: 100px;
    -webkit-border-top-left-radius: 0;
    -webkit-transform: rotate(0deg);
    -webkit-transform-origin:0 100%;
    width:50%;
    left:50%;
  }

  25.01%  { 
    -webkit-border-top-right-radius: 100px;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(0deg);
    -webkit-transform-origin:50% 100%;
    width:100%;
    left:0;
  }

  100% {
    -webkit-border-top-right-radius: 100px;
    -webkit-border-top-left-radius: 100px;
    -webkit-transform: rotate(270deg);
    -webkit-transform-origin:50% 100%;
    width:100%;
    left:0;
  }
}


.jmWatch {
  background-image:url('data:image/jpeg;base64,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');
  background-repeat:no-repeat;
  background-position:0 0;
  width:234px;
  height:300px;
  position:relative;
  margin:0 auto;
}

#linkage {
  position:fixed;
  top:145px;
  left:0px;
  background-color:#3d3d3d;
  color:#ffffff;
  text-decoration:none;
  padding:5px;
  width:10%;
}
</style>
<script type="text/javascript">

</script>
</head>
<body>
<h1>Animated Timer - CSS only - Webkit only for now</h1>
<a id="linkage" href="http://www.jasonmayes.com/" target="_blank">Visit my website</a>
<div class="jmWatch">
<div class="jmTimer">
  <div class="jmTicker"></div>
  <div class="jmMask"></div>
  <div class="jmFace"><p>60 sec.</p></div>
</div>
</div>
</body>
</html> 