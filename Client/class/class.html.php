<?
class Html extends System{
  function __construct(){
    $this->lang = $this->setLang();
  }
  public function loadMain(){
    ?>
    <html lang="<?=$this->lang?>">
      <?=$this->setMeta();?>
      <?=$this->setHead();?>
      <?=$this->setBody();?>
    </html>
    <?
  }
  private function setMeta(){
    ?>
    <meta charset="UTF-8">
    <meta class="viewport" name="viewport" content="user-scalable=yes,initial-scale=1, maximum-scale=1, minimum-scale=1">
    <?
  }
  private function setHead(){
    ?>
    <head>
      <link rel="stylesheet" href="https://k22pr.github.io/TisBe-CSS-Theme/css/index.css">
      <link rel="stylesheet" href="./css/index.css">

      <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.min.js" type="javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
      <script src="./js/index.js"></script>
    </head>
    <?
  }
  private function setBody(){
    ?>
    <body>
      <?=$this->setHeader()?>
      <?=$this->setSection()?>
      <?=$this->setFooter()?>
    </body>
    <?
  }
  private function setHeader(){
    ?>
    <header>
    </header>
    <?
  }

  private function setSection(){
    $page = new Page();
    ?>
    <?=$this->setSide()?>
    <section class="wac10">
      <?=$page->Location()?>
    </section>
    <?
  }
  private function setFooter(){
    ?>
    <footer>
    </footer>
    <input type="hidden" id="pub" value="<?=$this->getPub()?>">
    <?
  }
  private function setSide(){
    ?>
    <aside class="minify">
      <div class="w12 box blue tright p7 m0">
        <div class="w12"></div>
        <div class="w12"></div>
      </div>
      <ul class="w12">
          <?=$this->SideCoinList()?>
      </ul>
      <div class="side-foot small"></div>
    </aside>
    <?
  }
  private function SideCoinList(){
    foreach(slist("","coin","1=1 order by no asc") as $list){
      if($list->unit == "BTC") $unit = "USD_".$list->unit;
      else $unit = "BTC_".$list->unit;
      ?>
        <li class="w12">
          <div class="w6 only-line"><?=$list->ko?></div>
          <div class="w6"></div>
        </li>
      <?
    }
  }
}