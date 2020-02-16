<?php 
define('DB_HOST', 'localhost');
define('DB_USER', 'avoda_db');
define('DB_PASSWORD', 'y}jh!u]wLx&+');
define('DB_NAME', 'avoda');

function jewishdate($ts){
	$d = gregoriantojd(date('n',$ts),date('j',$ts),date('Y',$ts)); 
    $m = jdmonthname($d,4);
    $d = explode('/',jdtojewish($d)); 
    return "{$d[1]} $m {$d[2]}";
}