<?php

include('../fn.php');

$ret = array();

/*	DB
------------------------------------------*/
	if ( ! isset($_GET['db'])) {
		$ret['success'] = false;
		$ret['msg'] = "no db provided";
		echoData($ret);
	}

	$db = $_GET['db'];

	if ( ! is_dir($db)) {
		$ret['success'] = false;
		$ret['msg'] = "db `" . $db . "` not found";
		echoData($ret);
	}

/*	Limit
------------------------------------------*/
	$limit = null;

	if (isset($_GET['limit'])) {
		$limit = $_GET['limit'];
	}



/*	Get the row ids
------------------------------------------*/
	$dir = $db.'/data/';
	$files = getFiles($dir);

	if ($limit) {
		$files = array_slice($files, -$limit);
	}

	array_reverse($files);



/*	Collect the data
------------------------------------------*/
	$rows = array();
	foreach ($files as $filename) {
		$row = array();
		$row['date'] = substr($filename, 0, 4) . '-' . substr($filename, 4, 2) . '-' . substr($filename, 6, 2);
		$row['time'] = substr($filename, 8, 2) . ':' . substr($filename, 10, 2) . ':' . substr($filename, 12, 2);

		$json = file_get_contents($dir.$filename);
		$data = json_decode($json, true);
		if ($data) {
			$row['data'] = $data;
		}
		array_push($rows, $row);
	}



/*	Echo the data
------------------------------------------*/
	echoData($rows);


?>