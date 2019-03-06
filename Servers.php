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
  }
  catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
  }
  ?>
