<?php
require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$lastfm_key = $_ENV['LASTFM_KEY'];
$username=$_POST['username'];
$json = file_get_contents('https://ws.audioscrobbler.com/2.0/?'.
                            'method=user.getweeklyalbumchart&'.
                            'user='.$username.'&'.
                            'api_key='.$lastfm_key.'&'.
                            'format=json');
$obj = json_decode($json);
echo $obj->weeklyalbumchart->album[0]->name;

?>