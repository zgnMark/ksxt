<?php
$sql = file_get_contents('database_v1.sql');
$pdo = new PDO("mysql:host=localhost;dbname=database_v1","root","root");
if($pdo -> exec("drop database database_v1")){
    if($pdo -> exec("create database database_V1"))
    {
        echo $pdo ->exec($sql)?  'ok' : 'no';
    }

} else {
    echo '删除失败';
}