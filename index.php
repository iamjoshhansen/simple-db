<?php

include('../fn.php');

$ret = array();

/*	Data
------------------------------------------*/
	$data = null;

	if (isset($_GET['data'])) {
		$data = json_decode($_GET['data'], true);
	} else {
		/*$ret['success'] = false;
		$ret['msg'] = "no data provided";
		echoData($ret);*/
	}



/*	DB
------------------------------------------*/
	if ( ! isset($_GET['db'])) {
		$ret['success'] = false;
		$ret['msg'] = "no data provided";
		echoData($ret);
	}

	$db = $_GET['db'];

	if ( ! is_dir($db)) {
		mkdir($db);
		mkdir($db.'/data');
	}


/*	Row ID
------------------------------------------*/
	$latest_filename = $db.'/latest.json';
	$date = date("YmdHis");
	$latest = array();
	if (is_file($latest_filename)) {
		$latest = json_decode(file_get_contents($latest_filename), true);
		if ($latest['d'] < $date) {
			$latest['d'] = $date;
			$latest['i'] = 0;
		} else {
			$latest['i']++;
		}
	} else {
		$latest['d'] = $date;
		$latest['i'] = 0;
	}


	file_put_contents($latest_filename, json_encode($latest));

	$row_id = $latest['d'].'.'.$latest['i'];


/*	Write the Data
------------------------------------------*/
	$success = file_put_contents($db.'/data/'.$row_id.'.json', json_encode($data, JSON_PRETTY_PRINT));


/*	Pass to parsers
------------------------------------------*/
	$parsers = getFolders($db.'/parsers');
	foreach ($parsers as $dir) {
		$prefix = $db.'/parsers/'.$dir.'/';
		$inc = $prefix.'_.php';
		include($inc);
	}


/*	Cleanup
------------------------------------------*/
	$ret['success'] = !!$success;
	echoData($ret);

?>