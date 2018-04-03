<?php
/*语音搜索*/

?>

<!DOCTYPE html>
<html>
<head>
	<title>语音搜索</title>
</head>
<body>
<input type="search" x-webkit-speech onwebkitspeechchange="onChange()"/>
<script type="text/javascript">
// if (document.createElement("input").webkitSpeech === undefined) { 

//     alert("Speech input is not supported in your browser."); 

// } 

function onChange() {

        alert('changed');

    }
</script>
</body>
</html>