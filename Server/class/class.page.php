<?php
  Class Page extends System{
    function __construct(){
      $this->date = date("Y-m-d H:i:s");
      $this->time = time();
    }

    public function location(){
      if($_SERVER["QUERY_STRING"] == "") $this->mainPage();
      else if(isset($_GET["ticker"])) $this->getTicker();
      else if(isset($_GET["chart"])) $this->getChart();
      else if(isset($_GET["crontab"])) $this->cronData();
      else header("HTTP/1.0 404 Not Found");
    }

    private function mainPage(){

    }

    private function getTicker(){
      $pol = new poloniex();
      $pol->TotalTicker();
    }

    private function getChart(string $name = NULL,dobule $start = NULL, double $end = NULL, int $period = 0){
      $pol = new poloniex();
      $log = new Log(4);

      $name = (string) ($name ?? $_GET["name"]);
      $startDate = (double) ($start ?? $_GET["start"] ?? $this->time - (60*60+59));
      $endDate = (double) ($end ?? $_GET["end"] ?? 9999999999);
      $period = (int) ($peroid ?? $_GET["period"] ?? 300);

      if(!$name){
        $log->setLevel(4);
        $log->setLog("{name} match error.","did not receive {name}. need a Get type value {name}.");
      }else{
        //setting name
        //check name
        $check = select("no","ticker","name = ?",[$name]);
        if(empty($check->no)){
          $log->setLevel(4);
          $log->setLog("{name} match error.","Cannot find search returnChart {name}. returnChart is need search {name}.");
        }else{
          //get chart
          $pol->returnChart($name,$startDate,$endDate,$period);
        }
      }
    }

    private function cronData(){
      $this->getTicker();
      foreach(slist("name","ticker","1=1 order by no asc") as $list){
        $this->getChart($list->name);
      }
    }
  }
?>