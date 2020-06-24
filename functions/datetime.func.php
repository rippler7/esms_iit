<?php 
# DATETIME FUNCTIONS

function get_timestamp()
# Author       : Rex S. Sacayan
# Date created : December 13, 2013
# Date modified: January 15, 2014
# Description  : Get current timestamp with microseconds
{
	date_default_timezone_set('Asia/Manila');
    $t = microtime(true);
	$micro = sprintf("%06d",($t - floor($t)) * 1000000);
	$d = new DateTime(date('Y-m-d H:i:s.'.$micro,$t) );
	return $d->format("Y-m-d H:i:s.u");	
}

function get_timestamp_interval($date) 
# Author       : Rex S. Sacayan
# Date created : December 13, 2013
# Date modified: December 13, 2013
# Description  : Get time interval between current datetime and specified datetime (usually old datetime)
{
    $time_old = strtotime($date);
    $time_now = strtotime(get_timestamp());
    $difference = $time_now - $time_old;
    $info['days'] = (int)($difference / 86400);
    $info['hours'] = (int)($difference / 3600);
    $info['minutes'] = (int)($difference / 60);
    $info['seconds'] = $difference;

   return $info;
}
?>