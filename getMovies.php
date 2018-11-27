<?php 
    require 'inc/functions.php';

    $functions = new Data();

    if(isset($_POST['genre']) && isset($_POST['year'])) {
        $genre = $_POST['genre'];
        $year = $_POST['year'];

        $films = [
           'movies' => $functions->getMovies($genre, $year)
        ];
    }
?>


    <?php foreach($films['movies'] as $film) {
        echo '<h2><a href="films.php?id=' . $film->MovID . '">' . $film->MovTitle . '</a></h2>';
    } 
    ?>
