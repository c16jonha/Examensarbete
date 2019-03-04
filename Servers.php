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
    $i = 0;
      foreach ($articles as $article) {
        echo "<h2 onclick='ShowText(\"content\",".$i.")'>".$article['heading']."</h2><hr>";
        echo "<div class='content'>";
        echo "<p>".$article['author']."</p>";
        echo "<p>".$article['bodytext']."</p>";
        echo "<p>".$article['published']."</p><hr>";
        echo "</div>";
        $i++;
      }
  }
  catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
  }
  ?>
