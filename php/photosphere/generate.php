<?php

echo '<pre>'.htmlentities('<html>
  <head>
	<title></title>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	<style> body {font-family: Arial,Verdana} </style>
  </head>
  <body>
	<h1>IoT-Lab</h1>
	<g:panoembed imageurl="'.$_GET['image_url'].'" fullsize="'.$_GET['fullsize'].'" croppedsize="'.$_GET['croppedsize'].'" offset="'.$_GET['offset'].'" displaysize="666,500"/>
	<script>
	  gapi.panoembed.go();
	</script>
  </body>
</html>').'</pre>';
?>
