<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="main.css">
  <script src="script.js"></script>
</head>
<body>
  <div id="header">
    <h1 onclick="homePage()">Artefakt</h1>
    <form method = "post">
      <input type="text" id="searchBar" name="searchBar" placeholder="Search.." value=""/>
      <button id="searchButton" type="submit" name="search"><img id="searchImg" src="search.png"></img></button>
    </form>
  </div>
  <div id = "container">
        <?php
          include "Servers.php";
        ?>
        <script>
          //function that saves the query response time in localStorage and prints it out in the console
            var TimeString ="<?php echo $log_time; ?>";
            if(localStorage.getItem('Times')!=null){
              TimeString += localStorage.getItem('Times');
            }
            localStorage.setItem('Times', TimeString);
            console.log(TimeString);
        </script>
  </div>
  <div id="publisher">
    <form method="post">
      Heading: <input type="text" id="headingInput" name="headingInput"  placeholder="Write your heading...">
      <br>
      Subheading: <input type="text" id="subheadingInput" name="subheadingInput"  placeholder="Write your subheading...">
      <br>
      bodytext: <input type ="text" id="bodytextInput" name="bodytextInput" placeholder="Write your bodytext...">
      <br>
      Author: <input type="text" id="authorInput" name="authorInput" placeholder="Write your name...">
      <br>
      <button id="Publish" type="submit" name="publish">Publish</button>
    </form>
  </div>
  <!--<div id = "footer">
  </div>-->
</body>
</html>
