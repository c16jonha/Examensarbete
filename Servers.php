<?php
  $dbname = "test";
  $servername = "localhost";
  $username = "root";
  $password ="";
  // Create connection
  try {
    $conn = new LoggedPDO("mysql:host=$servername; dbname=test", $username, $password); //new PDO connection to db
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // profiling init

    $stmt = $conn->prepare('Select * from articles');
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $articles = $stmt->fetchAll();

    //Loops out every row in the articles table as div
    $i = 0;
      foreach ($articles as $article) {
        echo "<div class='Article'>";
        echo "<h2 onclick='showText(\"content\",".$i.")'>".$article['heading']."</h2><hr>";
        echo "<div class='content'>";
        echo "<p>".$article['author']."</p>";
        echo "<p>".$article['bodytext']."</p>";
        echo "<p>".$article['published']."</p><hr>";
        echo "</div></div>";
        $i++;
      }
      echo "<div id='noResult'>";
      echo "<h2>No result was found</h2><hr>";
      echo "<div>";
      echo "<p>We could not find any matching results to your search</p>";
      echo "<p>Please try again</p>";
      echo "</div></div>";

      //Inserts the content from the form into the database as an article
      if(isset($_POST['publish'])){
        if(isset($_POST['headingInput']) && $_POST['authorInput'] && $_POST['bodytextInput'] != null){
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
        else{}
      }
    //Search that queries the DB
    if(isset($_POST['search'])){
      if(isset($_POST['searchBar']) != ""){
        echo '<style type="text/css"> #noResult{ display: none;}</style>';
        echo '<style type="text/css"> .Article{ display: none;}</style>';
        $search = $_POST['searchBar'];
        $query = "SELECT * FROM articles WHERE heading LIKE '%".$search."%' OR author LIKE '%".$search."%' Or bodytext LIKE '%".$search."%' Or published LIKE '%".$search."%'";
        $stmt= $conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if($results != null){
        $i = 0;
          foreach ($results as $result) {
            echo "<div class='searchResult'>";
            echo "<h2 onclick='showText(\"searchContent\",".$i.")'>".$result['heading']."</h2><hr>";
            echo "<div class='searchContent'>";
            echo "<p>".$result['author']."</p>";
            echo "<p>".$result['bodytext']."</p>";
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
  }
  catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
  }
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
  /**
  * Extends PDO and logs all queries that are executed and how long
  * they take, including queries issued via prepared statements
  */
  class LoggedPDO extends PDO{
    public static $log = array();

    public function __construct($servername, $username, $password ) {
      parent::__construct($servername, $username, $password);
    }
    /**
    * Print out the log when we're destructed. I'm assuming this will
    * be at the end of the page. If not you might want to remove this
    * destructor and manually call LoggedPDO::printLog();
    */
    public function __destruct(){
      self::printLog();
    }
    public function query($query){
      $start = microtime(true);
      $result = parent::query($query);
      $time = microtime(true) - $start;
      LoggedPDO::$log[] = array('time'=>round($time * 1000, 3));
      return $result;
    }
    /*@return LoggedPDOStatement*/
    public function prepare($query, $options = NULL){
      return new LoggedPDOStatement(parent::prepare($query, $options = array()));
    }
    public function printLog(){
      $totalTime = 0;
      echo '<table onload="saveTime()" border=1><tr><th>Query</th><th>Time (ms)</th></tr>';
      $i = 1;
      foreach(self::$log as $entry){
        $totalTime += $entry['time'];
        echo '<tr><td>Query '.$i.'</td><td class="entryTime">'.$entry['time'].'</td></tr>';
        $i++;
      }
      echo '<tr><th>'.count(self::$log).' queries</th><th>Total time: '.$totalTime.'</th></tr>';
      echo '</table>';
    }
  }
  /*
  * PDOStatement decorator that logs when a PDOStatement is
  * executed, and the time it took to run
  * @see LoggedPDO
  */
  class LoggedPDOStatement {
    /** * The PDOStatement we decorate*/
    private $statement;
    public function __construct(PDOStatement $statement){
      $this->statement = $statement;
    }
    /*** When execute is called record the time it takes and then log the query @return PDO result set*/
    public function execute(){
      $start = microtime(true);
      $result = $this->statement->execute();
      $time = microtime(true) - $start;
      LoggedPDO::$log[] = array('time'=>round($time * 1000, 3));
      return $result;
    }
    /*
    * Other than execute pass all other calls to the PDOStatement object
    * @param string $function_name
    * @param array $parameters arguments
    */
    public function __call($function_name, $parameters){
      return call_user_func_array(array($this->statement, $function_name), $parameters);
    }
}
?>
