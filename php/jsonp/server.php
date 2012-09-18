<?php
	//http://www.onlinesolutionsdevelopment.com/blog/web-development/javascript/jsonp-example/

	// get the callback function name
	$callback = '';
	if (isset($_GET['callback']))
	{
		$callback = filter_var($_GET['callback'], FILTER_SANITIZE_STRING);
	}
	
	// make an array with some random values.. so you would see that the results are fetched each time you call this script
	$array = array(
					'item_id' => rand(1,13),
					'price' => rand(14,17),
					'quantity' => rand(18,30)
					
	);
	// output this array json encoded.. the callback function being the padding (a function available in the web page)
	echo $callback . '('.json_encode($array).');';
