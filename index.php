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
    <form method = "post">
      <input type="text" id="searchBar" placeholder="Search.." value=""/>
      <button type="submit" id="searchButton" onclick="searchFilter()"><img id="searchImg" src="search.png"></img></button>
    </form>
  </div>
  <div id = "container">
        <?php
          include "Servers.php";
        ?>
  </div>
  <div id="adder">
    <form method="post">
      Heading: <input type="text" name="headingInput" id="headingInput" placeholder="Write your heading...">
        <br>
      Author: <input type="text" name="authorInput" placeholder="">
        <br>
      bodytext: <input type ="text" name="bodytextInput" placeholder="Write your bodytext...">
        <br>
      <button id="Publish" type="submit" name="publish">Publish</button>
    </form>
  </div>
  <div id = "footer">
  </div>
</body>
</html>
