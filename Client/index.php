<?php
  //db connection
  require_once("../db.config.php");
  require_once("../db/db.sql.php");

  //load module
  require_once("../module.config.php");

  require_once("./class/class.system.php");
  require_once("./class/class.page.php");
  require_once("./class/class.html.php");

  $html = new Html();
  $html->LoadMain();

  
