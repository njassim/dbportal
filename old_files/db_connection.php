<?php
error_reporting(1);
//session_start();
$link = mysql_connect('localhost', 'cipldevc_jasim', 'Jasim#123');

$db_selected = mysql_select_db('cipldevc_cportal', $link);

$base_url="http://".$_SERVER['SERVER_NAME']."";

if (!$db_selected) {
    die('Database not connected : ' . mysql_error());
}
echo mysql_error();


?>
