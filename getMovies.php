<?php 
    require 'inc/functions.php';

    // create a new data object 
    $functions = new Data();

    // getting variables from an AJAX request in js/index.js 
    if(isset($_POST['genre']) && isset($_POST['year'])) {
        $genre = $_POST['genre'];
        $year = $_POST['year'];

        $films = [
           'movies' => $functions->getMovies($genre, $year)
        ];
    }
?>

<div class="row">
    <?php foreach($films['movies'] as $film) {
        echo '<div class="card col-sm-2">';
        echo    '<img class="imgs img-fluid" src="' . $film->MovPosterPath . '">';
        echo    '<div class="card-body">';
        echo        '<h5 class="card-title"><a href="films.php?id=' . $film->MovID . '">' . $film->MovTitle . '</a></h2>';
        echo    '</div>';
        echo '</div>';
    } 
    ?>
</div>

