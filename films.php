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
<?php include("inc/header.php"); ?>
    <div class="film-details">
        <h1><?php echo $movieInfo['info']->MovTitle; ?></h1>
        <img src="<?php echo $movieInfo['info']->MovPosterPath; ?>">
        <p>Release Date: <?php echo $movieInfo['info']->MovRelDate; ?></p>
        <p>Length: <?php echo $movieInfo['info']->MovLength; ?></p>
        <p>Director: <?php echo $movieInfo['info']->MovDirector; ?></p>
        <p>Actors: <?php echo $movieInfo['info']->MovActors; ?></p>
        <p>Plot: <?php echo $movieInfo['info']->MovPlot; ?></p>
        <h2>Ratings:</h2>
        <p>IMDb: <?php echo $movieInfo['info']->ImdbRate; ?></p>
        <p>Metacritic: <?php echo $movieInfo['info']->MetaRate; ?></p>
        <p>RottenTomatos: <?php echo $movieInfo['info']->RottRate; ?></p>

        <h2>YouTube Reviews</h2>
        <?php foreach($movieInfo['videos'] as $video) {
            echo '<iframe id="cartoonVideo" width="560" height="315" src="//www.youtube.com/embed/' . $video->VidID . '" frameborder="0" allowfullscreen></iframe><br>';
        }
        ?>
    </div>

<?php include("inc/footer.php"); ?>