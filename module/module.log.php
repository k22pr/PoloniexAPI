<?php
class Log{
  // level 0 = infomation, 2 = notice, 3 = warring, 4 = error
  private $level = 0;
  // view 0 = no alram
  private $view = 0;

  //constrct
  function __construct($level=NULL,$view=NULL){
    $this->level = $level ?? 0;
    $this->view = $view ?? $this->level ? 1 : 0;
  }

  //get set
  public function setLevel(int $level){
    $this->level = $level;
  }
  public function getLevel(){
    return $this->level;
  }
  public function setView(bool $view){
    $this->view = $view;
  }
  public function getView(){
    return $this->view;
  }


  public function setLog(string $title,string $msg){
    insert("api_log","level,title,description,view",[$this->level,$title,$msg,$this->view]);
    echo $title."<br>".$msg."<br>";
  }

}