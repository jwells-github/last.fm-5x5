<?php 
    class Album {
        public $artistName;
        public $albumName;
        public $playCount;
        public $imageUrls = array("small" =>"",
                                   "medium"=>"",
                                   "large"=>"",
                                   "extraLarge"=>"");

    
        public function __construct($jsonAlbum) {
            $this->artistName = $jsonAlbum->artist->name;
            $this->albumName = $jsonAlbum->name;
            $this->playCount = $jsonAlbum->playcount;
            $this->imageUrls["small"] = $jsonAlbum->image[0]->{'#text'};
            $this->imageUrls["medium"] = $jsonAlbum->image[1]->{'#text'};
            $this->imageUrls["large"] = $jsonAlbum->image[2]->{'#text'};
            $this->imageUrls["extraLarge"] = $jsonAlbum->image[3]->{'#text'};
        }
    }
?>