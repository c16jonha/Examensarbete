<?php
  $memcache = new Memcache;
  $memcache->connect("localhost",11211); # You might need to set "localhost" to "127.0.0.1"

   $memcache->set("key","hello i am key value lolololo");
   echo $memcache->get("key");
?>
