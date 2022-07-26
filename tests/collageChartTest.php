<?php

    use PHPUnit\Framework\TestCase;
    require_once  './classes/collageChart.php';
    require_once  './classes/album.php';

    final class collageChartTest extends TestCase{

        public function testCollageChartGridSize(){
            $jsonData = json_decode(file_get_contents("tests/testData.json"));
            $albumArray = array();
            for($i=0; $i<4; $i++){
                $albumArray[] = new Album($jsonData->topalbums->album[$i]);
            }

            $collageChart = new CollageChart($albumArray);

            $this->assertSame(count($albumArray),4);
            $this->assertSame($collageChart->gridSize,2.0);
        }

        public function testCollageChartGridSizeRoundsUp(){
            $jsonData = json_decode(file_get_contents("tests/testData.json"));
            $albumArray = array();
            for($i=0; $i<5; $i++){
                $albumArray[] = new Album($jsonData->topalbums->album[$i]);
            }

            $collageChart = new CollageChart($albumArray);

            $this->assertSame(count($albumArray),5);
            $this->assertSame($collageChart->gridSize,3.0);
        }

        public function testCollageChartReturnsPng(){
            $jsonData = json_decode(file_get_contents("tests/testData.json"));
            $albumArray = array();
            for($i=0; $i<1; $i++){
                $albumArray[] = new Album($jsonData->topalbums->album[$i]);
            }

            $collageChart = new CollageChart($albumArray);

            $this->assertSame($collageChart->generateChart()->getFormat(),"png");
        }   
    }

?>