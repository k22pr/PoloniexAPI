<?php
  //load db
  require_once("../db.config.php");
  require_once("../db/db.sql.php");

  //load class
  require_once("./class/class.system.php");
  require_once("./class/class.poloniex.php");

  //load module
  require_once("../module.config.php");
  
  //load page
  require_once("./class/class.page.php");
  
  $page = new Page();
  $page->location();
?>