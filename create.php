<?php

include('../fn.php');

$ret = array();

/*	DB
------------------------------------------*/
	if ( ! isset($_GET['db'])) {
		$ret['success'] = false;
		$ret['msg'] = "no data provided";
		echoData($ret);
	}

	$db = $_GET['db'];


/*	No accidental overwrites
------------------------------------------*/
	if (is_dir($db)) {
		$ret['success'] = false;
		$ret['msg'] = "db `$db` already exists";
		echoData($ret);
	}

function recurse_copy ($src,$dst) { 
    $dir = opendir($src); 
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                recurse_copy($src . '/' . $file,$dst . '/' . $file); 
            } 
            else { 
                copy($src . '/' . $file,$dst . '/' . $file); 
            } 
        } 
    } 
    closedir($dir); 
}


/*	Create new db
------------------------------------------*/
	recurse_copy('_template',$db);


/*	Final Echo
------------------------------------------*/
	$ret['success'] = true;
	echoData($ret);

?>