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
    <h1><?php echo $movieInfo['info']->MovTitle; ?></h1>
    <img src="<?php echo $movieInfo['info']->MovPosterPath; ?>"><br>
    <p>Director: <?php echo $movieInfo['info']->MovDirector; ?></p><br>
    <h2>YouTube Reviews</h2>
    <?php foreach($movieInfo['videos'] as $video) {
        echo '<iframe id="cartoonVideo" width="560" height="315" src="//www.youtube.com/embed/' . $video->VidID . '" frameborder="0" allowfullscreen></iframe><br>';
    }
    ?>

<?php include("inc/footer.php"); ?>