<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="main.css">
  <script src="script.js"></script>
</head>
<body>
  <div id="header">
    <h1>Artefakt</h1>
    <input type="text" id="searchBar" onkeydown="searchFunction()" placeholder="Search..">
  </div>
  <div id = "container">
        <?php
          include "Servers.php";
        ?>
  </div>
  <div id="adder">
      Heading: <input type="text" name="Heading" id="headingInput" placeholder="Write your heading...">
    <br>
      Author: <input type="text" name="author" placeholder="">
    <br>
      bodytext: <textarea type ="textfield" name="bodytext" placeholder="Write your bodytext..."></textarea>
    <br>
    <button id="Publish" type="submit" onclick="createArticle()">Publish</button>
  </div>
  <div id = "footer">
  </div>
</body>
</html>
