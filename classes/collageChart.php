<?php 
    require_once  'imageWriter.php';
    require_once  'album.php';
    class CollageChart {
    
        const HEIGHT_BETWEEN_TEXT = 50.0;
        const TEXT_STARTING_HEIGHT = 44.0;
        const IMAGE_HEIGHT = 300;
        const IMAGE_WIDTH = 300;
        private $drawSettings;
        private $albums;
        public $gridSize;

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
            $this->gridSize = ceil(sqrt(count($albums)));
        }

        public function generateChart(){
            $chart = new Imagick();
            // Create canvas to place images upon
            $chart->newImage(self::IMAGE_HEIGHT * $this->gridSize, self::IMAGE_WIDTH * $this->gridSize, new ImagickPixel('black'));
            $chart->setFormat("png");

            $i = 0;
            foreach($this->albums as $album){
                $albumArt = file_get_contents($album->imageUrls["extraLarge"]);
                $img = new Imagick();
                $img->readImageBlob($albumArt);
                // Double the image size to make it easier to write upon
                $img->resizeImage($img->getimageWidth()*2,$img->getimageHeight()*2,0,0);               

                $imageWriter = new ImageWriter(
                    $img,
                    self::TEXT_STARTING_HEIGHT,
                    self::HEIGHT_BETWEEN_TEXT,
                    $this->drawSettings
                );
;
                $imageWriter->write($album->artistName);
                $imageWriter->write($album->albumName);
                $img = $imageWriter->getImage();
                // half the image size
                $img->resizeImage($img->getimageWidth()/2,$img->getimageHeight()/2,0,0);               
                // Work out the next position on the grid to place the image
                $xPosition = ($i % $this->gridSize) * self::IMAGE_WIDTH;
                $yPosition = (intdiv($i, $this->gridSize)) * self::IMAGE_HEIGHT;
                // place the image on the canvas
                $chart->compositeImage($img, Imagick::COMPOSITE_DEFAULT, $xPosition, $yPosition);
                $i++;
            }
            $chart->setImageFormat("png");
            return $chart;
        }
    }
?>