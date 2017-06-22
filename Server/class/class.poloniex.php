<?php
  Class Poloniex{
    private $trade_url = "";
    private $public_url = "https://poloniex.com/public";
    function __construct(){
      $this->date = date("Y-m-d H:i:s");
      $this->time = time();
      $this->log = new Log(0);
    }

    public function TotalTicker(){
      $url = $this->public_url."?command=returnTicker";
      $json = file_get_contents($url);
      $data = json_decode($json);

      foreach($data as $name => $list){
        $errFlag = (bool) false;
        $check = select("no","ticker","id = ?",$list->id);
        try{
          print_R($check);
          if(isset($check->no)) update("ticker","price = ?, lowest = ?, highest = ?, frozen = ?","no = ?",[$list->last,$list->lowestAsk,$list->highestBid,$list->isFrozen,$check->no]);
          else insert("ticker","id, name, price, lowest, highest, frozen",[$list->id,$name,$list->last,$list->lowestAsk,$list->highestBid,$list->isFrozen]);
        }catch(Excetion $e){
          $log = new Log(3);
          $log->setLog("Update ticker fail","fail the $name ticker update.");
          $errFlag = true;
        }
      }

      //save Log
      if(!$errFlag){
        $log = new Log(0);
        $log->setLog("update ticker success.","Update to ".count($data)." data.");
      }
    }

    public function returnChart(string $name,string $startDate, string $endDate,int $period){
      $url = $this->public_url."?command=returnChartData&currencyPair=".$name."&start=".$startDate."&end=".$endDate."&period=".$period;
      $json = file_get_contents($url);
      $data = json_decode($json);
      if(isset($data->error)){
        $this->log->setLevel(4);
        $this->log->setLog("Chart load error.",$data->error);
      }else{
        foreach($data as $list){
          $check = select("no","chart_data","name = ? and time = ?",[$name,$list->date]);
          if(isset($check->no)) continue;
          else{
            insert("chart_data","name,time,high,low,open,close,avg,volume",[$name,$list->date,$list->high,$list->low,$list->open,$list->close,$list->weightedAverage,$list->volume]);
          }
        }
      }
    }
  }
?>