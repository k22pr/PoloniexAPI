<?php
  class System{
    function __construct(){
    }

    protected function setLang(){
      $lang = "ko";
      return $lang;
    }

    protected function getPub() : string{
      $check = select("pub","user_rsa","user = ? and time = ?",[$this->getUniqueID(),time()-(60*60*1)]);
      return $check->pub ?? "none";
    }

    protected function setPub() : string{
      $check = select("pub","user_rsa","user = ?",[$this->getUniqueID()]);
    }

    private function getUniQueID() : string{
      $hash = hash("sha512",$_SERVER["HTTP_USER_AGENT"].$_SERVER["REMOTE_ADDR"]);
      return (string) substr($hash,0,3).".".substr($hash,3,3).".".substr($hash,6,3).":".substr($hash,9,3).".".substr($hash,12,3).".".substr($hash,15,3);
    }

    protected function getPrice($unit, float $price) : string{
      if(0.001 < $price) return $price.$unit;
      else if(0.001 > $price) return  number_format($price*100000000)."사토시";
    }
    
  }