<?php
  require 'Data.php';
  $conn = new Data();

  $arr = $conn->getMovies(9);

  $data = [
      'arr' => $arr
  ];

/**
 * Library Requirements
 *
 * 1. Install composer (https://getcomposer.org)
 * 2. On the command line, change to this directory (api-samples/php)
 * 3. Require the google/apiclient library
 *    $ composer require google/apiclient:~2.0
 */
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}

require_once __DIR__ . '/vendor/autoload.php';

$htmlBody = <<<END
<form method="GET">
  <div>
    Search Term: <input type="search" id="q" name="q" placeholder="Enter Search Term">
  </div>
  <div>
    Max Results: <input type="number" id="maxResults" name="maxResults" min="1" max="50" step="1" value="2">
  </div>
  <input type="submit" value="Search">
</form>
END;

// This code will execute if the user entered a search query in the form
// and submitted the form. Otherwise, the page displays the form above.
if (isset($_GET['maxResults'])) {
foreach($data['arr'] as $movTitle) {
    echo $movTitle->MovTitle . ': ' . $movTitle->MovID . '<br>';

  /*
   * Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
   * {{ Google Cloud Console }} <{{ https://cloud.google.com/console }}>
   * Please ensure that you have enabled the YouTube Data API for your project.
   */
  $DEVELOPER_KEY = 'AIzaSyAstcwyn8iI6UyRqyCNYAkTfvX8myqio9k';

  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  // Define an object that will be used to make all API requests.
  $youtube = new Google_Service_YouTube($client);

  $htmlBody = '';
  try {
    $search = $movTitle->MovTitle . ' movie review'; 
    // Call the search.list method to retrieve results matching the specified
    // query term.
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
      'q' => $search,
      'maxResults' => $_GET['maxResults'],
    ));

    echo '<h1>' . $search . '</h1>';

    // json from youtube 
    $response = json_encode($searchResponse);

    $videos = '';

    // Add each result to the appropriate list, and then display the lists of
    // matching videos, channels, and playlists.
    foreach ($searchResponse['items'] as $searchResult) {
      $videoID = $searchResult['id']['videoId'];
      $videoTitle = $searchResult['snippet']['title'];
      switch ($searchResult['id']['kind']) {
        case 'youtube#video':
        try{
          $conn->insertVideoData($videoID, $videoTitle, $movTitle->MovID);
          $videos .= sprintf('<iframe id="cartoonVideo" width="560" height="315" src="//www.youtube.com/embed/%s" frameborder="0" allowfullscreen></iframe><br><br>',
             $searchResult['id']['videoId'],$searchResult['snippet']['thumbnails']['medium']['url']);
          break;
        } catch(Exception $e){
          echo $e->getMessage();
          die();
        }
      }
    }

    $htmlBody .= <<<END
    <h3>JSON from YouTube</h3>
    $response
    <h3>Videos</h3>
    <ul>$videos</ul>
    <h3>Passed data</h3>
END;
  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
}
}
?>

<!doctype html>
<html>
  <head>
    <title>YouTube Search</title>
  </head>
  <body>
    <?=$htmlBody?>
  </body>
</html>