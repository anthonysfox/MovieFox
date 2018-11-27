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
    }

?>