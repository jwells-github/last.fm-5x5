<?php

    use PHPUnit\Framework\TestCase;
    require_once  './classes/album.php';

    final class albumTest extends TestCase{

        public function testAlbumConstructor(){
            $jsonData = json_decode(file_get_contents("tests/testData.json"));

            $album = new Album($jsonData->topalbums->album[0]);

            $this->assertSame("mclusky",$album->artistName);
            $this->assertSame("mclusky Do Dallas",$album->albumName);
            $this->assertSame("418",$album->playCount);
            $this->assertSame("https://lastfm.freetls.fastly.net/i/u/34s/5bf6f5537730496ec938a09233b9710c.png",$album->imageUrls["small"]);
            $this->assertSame("https://lastfm.freetls.fastly.net/i/u/64s/5bf6f5537730496ec938a09233b9710c.png",$album->imageUrls["medium"]);
            $this->assertSame("https://lastfm.freetls.fastly.net/i/u/174s/5bf6f5537730496ec938a09233b9710c.png",$album->imageUrls["large"]);
            $this->assertSame("https://lastfm.freetls.fastly.net/i/u/300x300/5bf6f5537730496ec938a09233b9710c.png",$album->imageUrls["extraLarge"]);
        }
    }

?>