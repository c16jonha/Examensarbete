<?php
  $dbname = "test";
  $servername = "localhost";
  $username = "root";
  $password ="";
  $log_time = "";
  // Create connection
  try {
    $time = 0;
    $conn = new PDO("mysql:host=$servername; dbname=test", $username, $password); //new PDO connection to db
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //Inserts the content from the form into the database as an article
      if(isset($_POST['publish'])){
        if(isset($_POST['headingInput']) && $_POST['subheadingInput'] && $_POST['bodytextInput'] && $_POST['authorInput'] != null){
          $heading = $_POST['headingInput'];
          $subheading = $_POST['subheadingInput'];
          $bodytext = $_POST['bodytextInput'];
          $author = $_POST['authorInput'];
          $create = "INSERT INTO articles (heading, subheading, bodytext, author)
          VALUES (:HEADING,:SUBHEADING,:BODYTEXT,:AUTHOR)";
          $stmt= $conn->prepare($create);
          $stmt->bindParam(':HEADING', $heading);
          $stmt->bindParam(':SUBHEADING', $subheading);
          $stmt->bindParam(':BODYTEXT', $bodytext);
          $stmt->bindParam(':AUTHOR', $author);
          $stmt->execute();
          //Header that resets the parameters for POST
          header("Location: index.php");
        }
        else{}
      }

      // profiling init
      $stmt = $conn->prepare('Select * from articles');
      $start = microtime(true);
      $stmt->execute();
      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $articles = $stmt->fetchAll();
      $diff = microtime(true) - $start;
      $time = round($diff * 1000, 3);
      $log_time = $time .", ";

      //Loops out every row in the articles table as div
      $i = 0;
      foreach ($articles as $article) {
        echo "<div class='Article'>";
        echo "<h2 onclick='showText(\"content\",".$i.")'>".$article['heading']."</h2>";
        echo "<h3 onclick='showText(\"content\",".$i.")'>".$article['subheading']."</h3><hr>";
        echo "<div class='content'>";
        echo "<p>".$article['bodytext']."</p>";
        echo "<p><b> By: ".$article['author']."</b></p>";
        echo "<p>".$article['published']."</p>";
        echo "</div></div>";
        $i++;
      }
      echo "<div id='noResult'>";
      echo "<h2>No result was found</h2><hr>";
      echo "<div>";
      echo "<p>We could not find any matching results to your search</p>";
      echo "<p>Please try again</p>";
      echo "</div></div>";

    //Search that queries the DB
    if(isset($_POST['search'])){
      if(isset($_POST['searchBar']) != ""){
        echo '<style type="text/css"> #noResult{ display: none;}</style>';
        echo '<style type="text/css"> .Article{ display: none;}</style>';
        $search = $_POST['searchBar'];
        $query = "SELECT * FROM articles WHERE heading LIKE '%".$search."%' OR subheading LIKE '%".$search."%' OR author LIKE '%".$search."%' Or bodytext LIKE '%".$search."%' Or published LIKE '%".$search."%'";
        $stmt= $conn->prepare($query);
        $start = microtime(true);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $diff = microtime(true) - $start;
        $time = round($diff * 1000, 3);
        $log_time .= "".$time.", ";
        if($results != null){
        $i = 0;
          foreach ($results as $result) {
            echo "<div class='searchResult'>";
            echo "<h2 onclick='showText(\"searchContent\",".$i.")'>".$result['heading']."</h2>";
            echo "<h3 onclick='showText(\"searchContent\",".$i.")'>".$result['subheading']."</h3><hr>";
            echo "<div class='searchContent'>";
            echo "<p>".$result['bodytext']."</p>";
            echo "<p><b> By: ".$result['author']."</b></p>";
            echo "<p>".$result['published']."</p><hr>";
            echo "</div></div>";
            $i++;
          }
        }
        else{
          echo '<style type="text/css"> #noResult{ display: block;}</style>';
        }
      }
      else{
        echo '<style type="text/css"> #noResult{ display: none;}</style>';
        echo '<style type="text/css"> .searchResult{ display: none;}</style>';
        echo '<style type="text/css"> .Article{ display: Block;}</style>';
      }
    }
    //echo 'Query Response times(ms): '.$log_time.'<br>';
  }
  catch(PDOException $e){
    echo "Connection failed: ".$e->getMessage();
  }
?>
