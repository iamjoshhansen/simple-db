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


/*	Parser
------------------------------------------*/
	if ( ! isset($_GET['parser'])) {
		$ret['success'] = false;
		$ret['msg'] = "no parser provided";
		echoData($ret);
	}

	$parser = $_GET['parser'];

	if ( ! is_dir($db.'/parsers/')) {
		$ret['success'] = false;
		$ret['msg'] = "parsers dir not found for db `" . $db . "`";
		echoData($ret);
	}

	if ( ! is_dir($db . '/parsers/' . $parser)) {
		$ret['success'] = false;
		$ret['msg'] = "parser `" . $parser . "` not found for db `" . $db . "`";
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
	$dir = $db.'/parsers/'.$parser.'/data/';
	$files = getFiles($dir);

	if ($limit) {
		$files = array_slice($files, -$limit);
	}

	array_reverse($files);



/*	Collect the data
------------------------------------------*/
	$data = array();

	foreach ($files as $filename) {
		$count = file_get_contents($dir.$filename);
		$data[substr($filename, 0, -4)] = $count;
	}



/*	Echo the data
------------------------------------------*/
	echoData($data);


?>