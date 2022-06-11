<?php
    require  'classes/request.php';
    $username=$_GET['username'];
    $period=$_GET['period'];
    $limit=$_GET['limit'];
    $weWantGifChart = isset($_GET['gifChart']);
    $username = mb_ereg_replace("[^\w\s_-]", '', $username);
    
    try{
        $request = new Request($username, $period, $limit);
        $chart = $weWantGifChart ? $request->getGifChart() : $request->getCollageChart();
        header('Content-Type: image/'.$chart->getImageFormat());
        header('Content-Disposition: inline; filename="' . $username . ' chart.'.$chart->getImageFormat().'"');
        echo $chart->getImagesBlob();
    }
    catch (Exception $e){
        echo $e->getMessage();
        include ('index.html');
    }
?>