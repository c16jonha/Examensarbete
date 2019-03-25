<?php
  $servername = "localhost";
  $username = "root";
  $password ="";
  // Create connection
  try {
    $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password); //new PDO connection to db
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //
    $stmt = $conn->prepare('Select * from articles');
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $articles = $stmt->fetchAll();

    //Loops out every row in the articles table as div
    $i = 0;
      foreach ($articles as $article) {
        echo "<div class='Article'>";
        echo "<h2 onclick='ShowText(\"content\",".$i.")'>".$article['heading']."</h2><hr>";
        echo "<div class='content'>";
        echo "<p>".$article['author']."</p>";
        echo "<p>".$article['bodytext']."</p>";
        echo "<p>".$article['published']."</p><hr>";
        echo "</div></div>";
        $i++;
      }

      //Inserts the content from the form into the database as an article
      if(isset($_POST['publish'])){
        if(isset($_POST['headingInput']) && $_POST['authorInput'] && $_POST['bodytextInput'] != ""){
          $heading = $_POST['headingInput'];
          $author = $_POST['authorInput'];
          $bodytext = $_POST['bodytextInput'];
          $create = "INSERT INTO articles (heading, author, bodytext)
          VALUES (:HEADING,:AUTHOR,:BODYTEXT)";
          $stmt= $conn->prepare($create);
          $stmt->bindParam(':HEADING', $heading);
          $stmt->bindParam(':AUTHOR', $author);
          $stmt->bindParam(':BODYTEXT', $bodytext);
          $stmt->execute();
          //Header that resets the parameters for POST
          header("Location: index.php");
        }
        else{
          header("Location: index.php");
        }
      }
    //Search that queries the DB 
    if(isset($_POST['search'])){
      if(isset($_POST['searchBar']) != ""){
        echo '<style type="text/css"> .Article{ display: none;}</style>';
        $search = $_POST['searchBar'];
        $query = "SELECT * FROM articles WHERE heading || author || bodytext Like '%".$search."%'";
        $stmt= $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $i = 0;
          foreach ($results as $result) {
            echo "<div class='searchResult'>";
            echo "<h2 onclick='ShowText(\"searchContent\",".$i.")'>".$result['heading']."</h2><hr>";
            echo "<div class='searchContent'>";
            echo "<p>".$result['author']."</p>";
            echo "<p>".$result['bodytext']."</p>";
            echo "<p>".$result['published']."</p><hr>";
            echo "</div></div>";
            $i++;
          }
      }
      else{
        echo '<style type="text/css"> .searchResult{ display: none;}</style>';
        echo '<style type="text/css"> .Article{ display: Block;}</style>';
        header("Location: index.php");
      }
    }
  }
  catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
  }
?>
