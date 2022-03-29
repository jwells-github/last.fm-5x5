<?php

require_once('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$lastfm_key = $_ENV['LASTFM_KEY'];
$username=$_POST['username'];
$json = file_get_contents('http://ws.audioscrobbler.com/2.0/?'.
                            'method=user.gettopalbums&'.
                            'user='.$username.'&'.
                            'api_key='.$lastfm_key.'&'.
                            'format=json');
$obj = json_decode($json);
$url = $obj->topalbums->album[0]->image[3]->{'#text'};
$image = file_get_contents($url);
$img = new Imagick();
$img -> readImageBlob($image);
header('Content-Type: image/png');
echo $img;
?>