<?php

$group = date("YmdH");
$filename = $prefix.'data/'.$group.'.txt';
$count = 0;

if ( ! is_dir($prefix.'data'))
	mkdir($prefix.'data');

if (is_file($filename)) {
	$count = file_get_contents($filename);
}

$count++;
file_put_contents($filename, $count);

?>