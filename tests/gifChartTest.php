<?php

    use PHPUnit\Framework\TestCase;
    require_once  './classes/gifChart.php';
    require_once  './classes/album.php';

    final class gifChartTest extends TestCase{

        public function testGifChartReturnsGif(){
            $jsonData = json_decode(file_get_contents("tests/testData.json"));
            $albumArray = array();
            for($i=0; $i<1; $i++){
                $albumArray[] = new Album($jsonData->topalbums->album[$i]);
            }

            $gifChart = new GifChart($albumArray);

            $this->assertSame($gifChart->generateChart()->getFormat(),"gif");
        }   

        public function testGifChartHasAFrameForEachImage(){
            $jsonData = json_decode(file_get_contents("tests/testData.json"));
            $albumArray = array();
            for($i=0; $i<2; $i++){
                $albumArray[] = new Album($jsonData->topalbums->album[$i]);
            }

            $gifChart = new GifChart($albumArray);
            $this->assertSame($gifChart->generateChart()->getNumberImages(),2);
        }  
    }

?>