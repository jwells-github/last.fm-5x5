<?php
    require_once  'album.php';
    require_once  'gifChart.php';
    require_once  'collageChart.php';

    require_once(__DIR__.'/../vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->load();

    class Request {

        const MAX_ALBUMS = 36;
        private $username;
        private $period;
        private $limit;
        private $apiKey;
        private $albums = array();
        
        public function __construct($username, $period, $limit) {
            if($limit > self::MAX_ALBUMS){
                throw new Exception('You are requesting too many albums');
            }
            $this->username = mb_ereg_replace("[^\w\s_-]", '', $username);
            $this->period = mb_ereg_replace("[^\w\s_-]", '', $period);
            $this->limit = $limit;
            $this->apiKey = $_ENV['LASTFM_KEY'];
            $this->albums = $this->getAlbums($this->fetchData());
        }

        private function fetchData(){
            $fetchLocation = 'http://ws.audioscrobbler.com/2.0/?'.
                    'method=user.gettopalbums&'.
                    'api_key='.$this->apiKey.'&'.
                    'user='.$this->username.'&'.
                    'period='.$this->period.'&'.
                    'limit='.$this->limit.'&'.
                    'format=json';
            function get_http_response_code($url) {
                @$headers = get_headers($url);
                return substr($headers[0], 9, 3);
            }
            if(get_http_response_code($fetchLocation) != "200"){
                // Ignore the error code and try to receive the error message from Last.fm
                @$json = json_decode(file_get_contents(
                            $fetchLocation,
                            FALSE,
                            stream_context_create(array('http'=>array('ignore_errors' => TRUE)))));
                if (property_exists($json, 'message')) {
                    throw new Exception($json->message);
                }
                else{
                    throw new Exception('An error was encountered, please try again later');
                }
            }
            else{
                return json_decode(file_get_contents($fetchLocation));
            }
        }

        private function getAlbums($jsonData){
            if(count($jsonData->topalbums->album) < 1){
                throw new Exception('No albums have been scrobbled in this time frame');
            }
            $albumArray = array();
            foreach($jsonData->topalbums->album as $album){
                $albumArray[] = new Album($album);
            }
            return $albumArray;
        }

        public function getGifChart(){
            $gifChart = new GifChart($this->albums);
            return $gifChart->generateChart();
        }

        public function getCollageChart(){
            $collageChart = new CollageChart($this->albums);
            return $collageChart->generateChart();
        }
    }
?>