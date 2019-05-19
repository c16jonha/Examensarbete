<?php
  $dbname = "main";
  $servername = "localhost";
  $username = "root";
  $password ="";
  $log_time = "";
  // Create connection
  try {
    $memcache = new Memcache;
    $memcache->connect("localhost",11211);

    $time = 0;
    $conn = new PDO("mysql:host=$servername; dbname=main", $username, $password); //new PDO connection to db
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //DELETES the content from the database and resets auto_increment
    if(isset($_POST['delete'])){
      $deletearticle= "DELETE FROM articles";
      $stmt= $conn->prepare($deletearticle);
      $stmt->execute();

      $resetarticleinc= "ALTER TABLE articles auto_increment=0";
      $stmt= $conn->prepare($resetarticleinc);
      $stmt->execute();

      $deleteauthor = "DELETE FROM author";
      $stmt= $conn->prepare($deleteauthor);
      $stmt->execute();

      $resetauthorinc= "ALTER TABLE author auto_increment=0";
      $stmt= $conn->prepare($resetauthorinc);
      $stmt->execute();

      //Header that resets the parameters for POST
      header("Location: index.php");
    }
    else{}
    //Inserts the content from the form into the database as an article
    if(isset($_POST['publish'])){
      if(isset($_POST['headingInput']) && $_POST['subheadingInput'] && $_POST['bodytextInput'] && $_POST['authorInput'] != null){
        $heading = $_POST['headingInput'];
        $subheading = $_POST['subheadingInput'];
        $bodytext = $_POST['bodytextInput'];
        $author = $_POST['authorInput'];

        $createauthor = "INSERT INTO author (Name) VALUES (:AUTHOR)";
        $stmt= $conn->prepare($createauthor);
        $stmt->bindParam(':AUTHOR', $author);
        $stmt->execute();

        $createarticle= "INSERT INTO articles (heading, subheading, bodytext)
        VALUES (:HEADING,:SUBHEADING,:BODYTEXT)";
        $stmt= $conn->prepare($createarticle);
        $stmt->bindParam(':HEADING', $heading);
        $stmt->bindParam(':SUBHEADING', $subheading);
        $stmt->bindParam(':BODYTEXT', $bodytext);
        $stmt->execute();
        //Header that resets the parameters for POST
        header("Location: index.php");
      }
      else{}
    }

    $stmt = $conn->prepare('SELECT heading, subheading, bodytext, published, Name FROM articles INNER JOIN author on articles.ID = author.ID');
    $stmt->execute();
    $articles = $stmt->fetchAll();

    //Loops out every row in the articles table as div
    $i = 0;
    foreach ($articles as $article) {
      echo "<div class='Article'>";
      echo "<h2 onclick='showText(\"content\",".$i.")'>".$article['heading']."</h2>";
      echo "<h3 onclick='showText(\"content\",".$i.")'>".$article['subheading']."</h3><hr>";
      echo "<div class='content'>";
      echo "<p>".$article['bodytext']."</p>";
      echo "<p>Published by: ".$article['Name']." on ".$article['published']."</p>";
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
        if($memcache->get($search) != false){
          $start = microtime(true);
          $results = $memcache->get($search);
          $diff = microtime(true) - $start;
          $time = round($diff * 1000, 3);
          $log_time .= '{\"time\":'.$time.'},';
          $results = json_decode($results, true);
          $i = 0;
          foreach ($results as $result){
              echo "<div class='searchResult'>";
              echo "<h2 onclick='showText(\"searchContent\",".$i.")'>".$result['heading']."</h2>";
              echo "<h3 onclick='showText(\"searchContent\",".$i.")'>".$result['subheading']."</h3><hr>";
              echo "<div class='searchContent'>";
              echo "<p>".$result['bodytext']."</p>";
              echo "<p>Published by: ".$result['Name']." on ".$result['published']."</p>";
              echo "</div></div>";
              $i++;
          }
        }
        else{
          $query = "SELECT heading, subheading, bodytext, published, Name FROM articles INNER JOIN author on articles.ID = author.ID WHERE heading LIKE '%".$search."%' OR subheading LIKE '%".$search."%' Or bodytext LIKE '%".$search."%' Or published LIKE '%".$search."%' Or Name LIKE '%".$search."%'";
          $stmt= $conn->prepare($query);
          $start = microtime(true);
          $stmt->execute();
          $results = $stmt->fetchAll();
          $diff = microtime(true) - $start;
          $time = round($diff * 1000, 3);
          $log_time .= '{\"time\":'.$time.'},';
          if($results != null){
            $memcache->set($search, json_encode($results));
            $i = 0;
            foreach ($results as $result) {
              echo "<div class='searchResult'>";
              echo "<h2 onclick='showText(\"searchContent\",".$i.")'>".$result['heading']."</h2>";
              echo "<h3 onclick='showText(\"searchContent\",".$i.")'>".$result['subheading']."</h3><hr>";
              echo "<div class='searchContent'>";
              echo "<p>".$result['bodytext']."</p>";
              echo "<p>Published by: ".$result['Name']." on ".$result['published']."</p>";
              echo "</div></div>";
              $i++;
            }
          }
          else{
            echo '<style type="text/css"> #noResult{ display: block;}</style>';
          }
        }
      }
      else{
        echo '<style type="text/css"> #noResult{ display: none;}</style>';
        echo '<style type="text/css"> .searchResult{ display: none;}</style>';
        echo '<style type="text/css"> .Article{ display: Block;}</style>';
      }
    }
  }
  catch(PDOException $e){
    echo "Connection failed: ".$e->getMessage();
  }
?>
