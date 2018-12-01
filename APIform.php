<?php
    require 'Data.php';
    $conn = new Data();

    $option;
    $year;
    $submitData = $_POST['willSubmit'];
    $tmdb_movie_titles = [];
    $omdb_movie_data = [];

    if(isset($_POST['option'])) {
        $option = $_POST['option'];
    }
    if(isset($_POST['year'])) {
        $year = $_POST['year'];
    }

    getTitles($option, $year, $submitData);

    function getTitles($option, $year, $submitData){
        $tmdb_curl = curl_init();
        global $year;
        
        curl_setopt_array($tmdb_curl, array(
            CURLOPT_URL => "https://api.themoviedb.org/3/discover/movie?api_key=e2989408b406614cbbf43eb457c2c9df&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&primary_release_year=$year&with_genres=$option",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
          ));
        
          $response = curl_exec($tmdb_curl);
          $err = curl_error($tmdb_curl);
        
          $json_info = json_decode($response);
            
          curl_close($tmdb_curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            for ($i = 0; $i < 15; $i++) {
                $title = $json_info->results[$i]->title;
                getInformation($title, $year);
            }

            addDetailsToDatabase($submitData);
        }
    }

    function getInformation($title, $year) {

        $omdb_curl = curl_init();
        $movie_info = array();
        global $omdb_movie_data;
        $newTitle = str_replace(" ", "+", $title);

        curl_setopt_array($omdb_curl, array(
        CURLOPT_URL => "http://www.omdbapi.com/?t=$newTitle&y=$year&apikey=e19d2897",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "{}",
        ));

        $omdb_response = curl_exec($omdb_curl);
        $omdb_err = curl_error($omdb_curl);
        $omdb_info = json_decode($omdb_response);

        curl_close($omdb_curl);

        if ($omdb_err) {
        echo "cURL Error #:" . $err;
        } else {
            array_push($movie_info, $omdb_info->Title, $omdb_info->Released, $omdb_info->Runtime, $omdb_info->Director, $omdb_info->Actors, $omdb_info->Plot, $omdb_info->Poster, $omdb_info->Ratings[0]->Value, $omdb_info->Ratings[2]->Value, $omdb_info->Ratings[1]->Value);
            array_push($omdb_movie_data, $movie_info);
        }
    }

    function addDetailsToDatabase($submitData){

        if ($submitData == true) {
            global $conn;
            global $omdb_movie_data;
            global $option;
            global $year;

            for($i = 0; $i < sizeof($omdb_movie_data); $i++) {
                $movTitle = $omdb_movie_data[$i][0];
                $movRelDate = $omdb_movie_data[$i][1];
                $movLength = $omdb_movie_data[$i][2];
                $movDirector = $omdb_movie_data[$i][3];
                $movActors = $omdb_movie_data[$i][4];
                $movPlot = str_replace("'", '', $omdb_movie_data[$i][5]);
                $movPosterPath = $omdb_movie_data[$i][6];
                $imdbRate = $omdb_movie_data[$i][7];
                $metaRate =  $omdb_movie_data[$i][8];
                $rottRate = $omdb_movie_data[$i][9];
                switch ($option){
                    case 28:
                    $genreID = 3;
                    break;
                    case 10751:
                    $genreID = 4;
                    break;
                    case 16:
                    $genreID = 9;
                    break;
                    case 35:
                    $genreID = 6;
                    break;
                    case 27:
                    $genreID = 1;
                    break;
                    case 18:
                    $genreID = 8;
                    break;
                    default:
                    $genreID = 7;
                }
                
                switch ($year){
                    case 2010:
                    $yearID = 1;
                    break;
                    case 2011:
                    $yearID = 2;
                    break;
                    case 2012:
                    $yearID = 3;
                    break;
                    case 2013:
                    $yearID = 4;
                    break;
                    case 2014:
                    $yearID = 5;
                    break;
                    case 2015:
                    $yearID = 6;
                    break;
                    case 2016:
                    $yearID = 7;
                    break;
                    case 2017: 
                    $yearID = 8;
                    break;
                    case 2018:
                    $yearID = 9;

                }
            
                $conn->insertMovieData($movTitle, $movRelDate, $movLength, $movDirector, $movActors, $movPlot, $imdbRate, $metaRate, $rottRate, $movPosterPath, $genreID, $yearID);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <th>Movie Title</th>
        </tr>
        <?php for($i = 0; $i < 15; $i++) {?>
            <tr>
                <td><?php echo $omdb_movie_data[$i][0]; ?></td>
            </tr>
        <? } ?>
</body>
</html>