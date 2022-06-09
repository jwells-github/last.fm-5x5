<?php 
    include_once 'imageWriter.php';
    include_once 'album.php';
    class GifChart {
    
        const HEIGHT_BETWEEN_TEXT = 50.0;
        const TEXT_STARTING_HEIGHT = 44.0;
        private $drawSettings;
        private $albums;

        public function __construct($albums) {
            $drawSettings = new ImagickDraw();
            $drawSettings->setFillColor('#fff');
            $drawSettings->setFontSize(56); 
            $drawSettings->setFont("./fonts/Mukta-Bold.ttf");
            $drawSettings->setStrokeColor('#000');
            $drawSettings->setStrokeWidth(2.5);
            $drawSettings->setStrokeAntialias(true); 
            $drawSettings->setTextAntialias(true);
            $this->drawSettings = $drawSettings;
            $this->albums = $albums;

        }

        public function generateChart(){
            $chart = new Imagick();
            $chart->setFormat("gif");
            
            foreach($this->albums as $album){
                $albumArt = file_get_contents($album->imageUrls["extraLarge"]);
                $frame = new Imagick();
                $frame->readImageBlob($albumArt);
                $frame->setImageDelay(150);
                $frame->resizeImage($frame->getimageWidth()*2,$frame->getimageHeight()*2,0,0);               

                $imageWriter = new ImageWriter(
                    $frame,
                    self::TEXT_STARTING_HEIGHT,
                    self::HEIGHT_BETWEEN_TEXT,
                    $this->drawSettings
                );
                $imageWriter->write($album->artistName);
                $imageWriter->write($album->albumName);
                $chart->addImage($imageWriter->getImage());
            }
            $chart->setImageFormat("gif");
            return $chart;
        }
    }
?>