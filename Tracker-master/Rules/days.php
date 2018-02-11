<?php


$diffweek = abs(strtotime($SessionStart) - strtotime($SessionEnd)) / 604800;
$number = intval($diffweek);
                
function get_days(&$s, &$e){ 
	$r = array (); 
	$s = strtotime ( $s . ' GMT' ); 
	$e = strtotime ( $e . ' GMT' ); 	
	do{	 
	$r[] = gmdate ( 'Y-m-d', $s ); 
	$s += 86400 * 7; 
	} while ( $s <= $e ); 
	return $r;
}
?>
