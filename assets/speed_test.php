<?php

$link = 'http://mirror.internode.on.net/pub/test/10meg.test';
$start = time();
$size = filesize($link);
$file = file_get_contents($link);
$end = time();

$time = $end - $start;

$size = $size / 1048576;

$speed = $size / $time;

echo "Server's speed is: $speed MB/s";


?>