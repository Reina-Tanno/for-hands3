<?php

require_once("sys_config.php");

/**
 * ログ生成クラス
 *
 */
class Logger{
  
  var $file;
  
  /**
   * コンストラクタ
   *
   * @param unknown_type $filename
   * @return Logger
   */
  function Logger($filename){
    $this->file = fopen($filename,"w+");
  }
  
  /**
   * ログを書き込む
   *
   * @param unknown_type $string
   * @return unknown
   */
  function log($string){
    if(fwrite($this->file,$string . "\n")){
      return true;
    }else{
      return false;
    }
  }
  
  /**
   * ログを閉じる
   *
   */
  function close(){
    fclose($this->file);
  }
}

?>