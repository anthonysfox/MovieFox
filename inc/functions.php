<?php 
    include_once 'connection.php';

    class Data{

        public function __construct() {
            $this->db = new Connection();
        }

        public function getMovies($genre, $year) {
            try {
                $results = $this->db->query('select MovID, MovTitle, MovPosterPath from Movie where GenreID = ' . $genre . ' AND YearID = ' . $year);
            } catch (Exception $e) {
                echo "ERROR: " . $e->getMessage();
            }
        
            $films = $this->db->resultSet();

            return $films;
        }

        public function getMovie($id) {
            $movResults = $this->db->query('SELECT * FROM Movie WHERE MovID = ?');

            $movResults = $this->db->bind(1, $id);
    
            $movResults = $this->db->execute();

            $movResults = $this->db->single();

            return $movResults;
        }

        public function getVideos($id) {
            $vidResults = $this->db->query('SELECT * FROM Youtube WHERE MovID = ?');

            $vidResults = $this->db->bind(1, $id);

            $vidResults = $this->db->execute();

            $vidResults = $this->db->resultSet();

            return $vidResults;

        }

        public function insertVideoData($videoID, $videoTitle, $movID){
            $this->db->query("INSERT INTO Youtube(VidID, VidTitle, MovID) VALUES('$videoID', '$videoTitle', $movID)");
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

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