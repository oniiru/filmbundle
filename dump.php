<?php
require_once(dirname(__FILE__).'/wp-config.php');
global $wpdb;

try{
$sql = file_get_contents(dirname(__FILE__).'/database.my.sql');
var_dump($sql);
die;
$wpdb->query($sql);

//exec('mysqldump -u oniiruco_wrd18 -poZyNXNTlX1 oniiruco_wrd18 > database.sql');

}catch(Exeption $e){
       echo $e->getMessage();
}