<?php

require_once("sys_config.php");

/**
 * ���������饹
 *
 */
class Logger{
  
  var $file;
  
  /**
   * ���󥹥ȥ饯��
   *
   * @param unknown_type $filename
   * @return Logger
   */
  function Logger($filename){
    $this->file = fopen($filename,"w+");
  }
  
  /**
   * ����񤭹���
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
   * �����Ĥ���
   *
   */
  function close(){
    fclose($this->file);
  }
}

?>