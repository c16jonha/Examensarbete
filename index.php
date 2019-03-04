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
    <input type="text" placeholder="Search..">
  </div>
  <div id = "container">
    <div class="Article">
        <?php
          include "Servers.php";
        ?>
    </div>
  </div>
  <div id = "footer">
  </div>
</body>
</html>
