<?php 
    class ImageWriter {

        const MAX_CHARACTERS_PER_LINE = 21;
        private $image;
        private $heightBetweenText;
        private $writingPosition;
        private $drawSettings;

        public function __construct($image, $textStartingHeight, $heightBetweenText, $drawSettings) {
            $this->image = $image;
            $this->writingPosition = $textStartingHeight;
            $this->heightBetweenText = $heightBetweenText;
            $this->drawSettings = $drawSettings;
        }

        public function write($text){
            $text = explode(" ", $text);
            $drawHeight = $this->writingPosition;
            $line="";
            foreach($text as $word){
                // add another word to the line if it would not 
                // exceed the character limit
                if(strlen($line) + strlen($word) <= self::MAX_CHARACTERS_PER_LINE){
                    $line = $line." ".$word;
                }
                // otherwise print the line to the image
                // and start a new line
                else{
                    $this->writeLineToImage($line);
                    $line = " ".$word;
                    $drawHeight += $this->heightBetweenText;
                }
            }
            // Write the remaining words to the image
            $this->writeLineToImage($line);
            // Update the writing position for any further writing
            $this->writingPosition = $drawHeight + $this->heightBetweenText;
        }

        public function getImage(){
            return $this->image;
        }

        private function writeLineToImage($line){
            $drawWidth = 5;
            $drawAngle = 0;
            $this->image->annotateImage(
                $this->drawSettings,
                $drawWidth, 
                $drawHeight, 
                $drawAngle,
                $line
            );
        }
    }
?>