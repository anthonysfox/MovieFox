<?php 
    require_once 'inc/functions.php';

    $functions = new Data();

    if(isset($_GET['id'])) {
        $film_id = intval($_GET['id']);
    
        $movieInfo = [
            'info' => $functions->getMovie($film_id),
            'videos' => $functions->getVideos($film_id)
        ];

    }

    $pageTitle = $movieInfo['info']->MovTitle;
    
?>
<?php include 'inc/header.php' ?>
    <div class="container">
    <div class="film-details">
            <h1 class="movie-title"><?php echo $movieInfo['info']->MovTitle; ?></h1>
            <img class="poster img-fluid" src="<?php echo $movieInfo['info']->MovPosterPath; ?>">
            <div class="information">
                <p><strong>Release Date:</strong> <?php echo $movieInfo['info']->MovRelDate; ?></p>
                <p><strong>Length:</strong> <?php echo $movieInfo['info']->MovLength; ?> min</p>
                <p><strong>Director:</strong> <?php echo $movieInfo['info']->MovDirector; ?></p>
                <p><strong>Actors:</strong> <?php echo $movieInfo['info']->MovActors; ?></p>
                <p><strong>Plot:</strong> <?php echo $movieInfo['info']->MovPlot; ?></p>
                <h2>Ratings:</h2>
                <p><strong>IMDb:</strong> <?php echo $movieInfo['info']->ImdbRate; ?>/10</p>
                <p><strong>Metacritic:</strong> <?php echo $movieInfo['info']->MetaRate; ?>/100</p>
                <p><strong>RottenTomatos:</strong> <?php echo $movieInfo['info']->RottRate; ?>/100</p>
            </div>
        <div class="youtube-videos">
        <h2>YouTube Reviews</h2>
            <?php foreach($movieInfo['videos'] as $video) {
                echo '<iframe id="cartoonVideo" width="500" height="315" src="//www.youtube.com/embed/' . $video->VidID . '" frameborder="0" allowfullscreen></iframe>';
            }
            ?>
        </div>
    </div>
    </div>

<?php include 'inc/footer.php' ?>