<?php 
    include_once 'connection.php';

    /**
     * Purpose of this class is to have all function accessing database in one place 
     */
    class Data{

        private $db;

        public function __construct() {
            $this->db = new Connection();
        }

        /**
         * Function to retrieve list of movies to be displayed
         * 
         * @param $genre refers to genre id 
         * @param $year refers to year id 
         */
        public function getMovies($genre, $year) {
            try {
                $results = $this->db->query('select MovID, MovTitle, MovPosterPath from Movie where GenreID = ' . $genre . ' AND YearID = ' . $year);
            } catch (Exception $e) {
                echo "ERROR: " . $e->getMessage();
            }
        
            $films = $this->db->resultSet();

            return $films;
        }

        /**
         * Get the details from selected movied 
         * 
         * @param $id is coming from movie selected 
         */
        public function getMovie($id) {
            $movResults = $this->db->query('SELECT * FROM Movie WHERE MovID = ?');

            $movResults = $this->db->bind(1, $id);
    
            $movResults = $this->db->execute();

            $movResults = $this->db->single();

            return $movResults;
        }

        /**
         * Get videos associated with a movie id 
         * 
         * @param $id is id of movie 
         */
        public function getVideos($id) {
            $vidResults = $this->db->query('SELECT * FROM Youtube WHERE MovID = ?');

            $vidResults = $this->db->bind(1, $id);

            $vidResults = $this->db->execute();

            $vidResults = $this->db->resultSet();

            return $vidResults;

        }

        /**
         * Used with youtube api to submit data to database 
         * 
         * @param $videoID is the id of the youtube video 
         * @param $videoTitle is the title of the youtube video
         * @param $id is the id of the movie being passed in 
         */
        public function insertVideoData($videoID, $videoTitle, $movID){
            $this->db->query("INSERT INTO Youtube(VidID, VidTitle, MovID) VALUES('$videoID', '$videoTitle', $movID)");
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        /**
         * Used with OMDb API to insert details from each movie into the database 
         */
        public function insertMovieData($movTitle, $movRelDate, $movLength, $movDirector, $movActors, $movPlot, $imdbRate, $metaRate, $rottRate, $movPosterPath, $genreID, $yearID){
            $this->db->query("INSERT INTO Movie(MovTitle, MovRelDate, MovLength, MovDirector, MovActors, MovPlot, ImdbRate, MetaRate, RottRate, MovPosterPath, GenreID, YearID) VALUES('$movTitle', '$movRelDate', '$movLength', '$movDirector', '$movActors', '$movPlot', '$imdbRate', '$metaRate', '$rottRate', '$movPosterPath', '$genreID', '$yearID')");
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
    }

?>