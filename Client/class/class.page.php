<?php
  class Page extends System{
    function __construct(){
      $this->date = date("Y-m-d H:i:s");
      $this->time = time();
    }
    
    public function Location(){
      if($_SERVER["QUERY_STRING"] === "") $this->MainPage();
    }
    private function MainPage(){
      ?>
        <article class="w12">
          <div class="w8">
            <?=$this->getChart('BTC_ZEC')?>
          </div>
          <div class="w4">
            
          </div>
        </article>
        <article class="w12">
            <div class="wd6">
              <?=$this->getChart('BTC_XRP')?>
            </div>
            <div class="wd6">
              <?=$this->getChart('BTC_LTC')?>
            </div>
        </article>
      <?
    }
    private function getChart(string $name){
      $unit = explode("_",$name);
      $coin[0] = select("","coin","unit = ?",[$unit[0]]);
      $coin[1] = select("","coin","unit = ?",[$unit[1]]);
      $data = select("","ticker","name = ?",[$name]);
      foreach(slist("","chart_data","name = ? order by time desc limit 0,10",[$name]) as $no => $list){
        $val[] = $list->avg;
        $time[] = substr($list->time,0,2);
      }
      $val[] = $data->price;
      $time[] = "now";
      
      ?>
        <div class="w12 box chart" id="<?=$name?>">
          <input type="hidden" id="valueData" value='<?=json_encode($val)?>'>
          <input type="hidden" id="labelData" value='<?=json_encode($time)?>'>
          <div class="w12 b5 p0"><span class="name" v-model="name"><?=$name?></span></div>
          <canvas class="w12" id="<?=$name?>_chart">
          </canvas>
          <div class="w12 small-text tleft pt5">
            <div class="w2 small-color only-line"><?=$coin[1]->ko?></div>
            <div class="w3 label-low">최저 <?=$this->getPrice($unit[0],$data->lowest)?></div>
            <div class="w3 label-high">최고 <?=$this->getPrice($unit[0],$data->highest)?></div>
            <div class="w3 label-price">현재 <?=$this->getPrice($unit[0],$data->price)?></div>
          </div>
          <script>
            var base = "<?=$name?>";
            var basel = '#'+base;
            var ctx = document.getElementById(base+"_chart").getContext('2d');
            var labelData = $(basel).children("input#labelData").val();
            var valueList = $(basel).children("input#valueData").val();
            console.log($(basel).children("input#labelData").val())
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
                    labels: <?=json_encode($time)?>,
                    datasets: [{
                        label: $(basel).attr("id"),
                        backgroundColor: 'rgba(255, 99, 132,0)',
                        borderColor: 'rgba(255, 99, 132,1)',
                        data: <?=json_encode($val)?>,
                    }]
                },

                // Configuration options go here
                options: {}
            });
          </script>
        </div>
      <?
    }
  }