<?php
require_once("sys_config.php");
require_once("japaneseDate.php");
require_once("Logger.class.php");

/**
 * 毎月の予約状況を管理するクラス
 * 
 * description:
 * 　月ごとにファイルで管理されている予約状況を解析して、予約状況を参照するためのいくつかの
 * メソッドを提供する。
 */
class MonthlyScheduleManager{
  var $year;
  var $month;
  var $file;
  var $schedule;
  var $holidays;
  var $calendar;
  var $logger;

  
  function MonthlyScheduleManager($year,$month,$logger = null){
    $this->year = $year;
    $this->month = $month;
    $this->calendar = new japaneseDate();
    $this->holidays = $this->calendar->getHolidayList(mktime(0,0,0,$month,1,$year));
    if($month < 10 && strlen($month) < 2){
      // 月の文字列を変換する　ex) 3 ⇒ 03
      $month = "0".$month;
    }
    $this->schedule = array();
    $this->logger = $logger;
    $path = "../data/".$year.$month.".dat";
    if(file_exists($path) && $this->file = fopen($path,"r")){
      $this->parse();
    }
  }

  /**
   * ファイルを解析する
   */ 
  function parse(){
    while(!feof($this->file)){
      $cols = fgetcsv($this->file,1000,",");
      $this->putProfiles(intval($cols[1]),intval($cols[2]),intval($cols[3]));
    }
  }
  
  /**
   * ２次元配列に予約を配置する
   *
   * @param unknown_type $date
   * @param unknown_type $start
   * @param unknown_type $finish
   */
  function putProfiles($date,$start,$finish){
    if($start >= $finish){
      return;
    }else{
      // 現在の開始時間の予約を配列に配置する
      $term = $this->getTerm($start);
      if(!array_key_exists($date,$this->schedule)){
        $this->schedule[$date] = array();
      }
      $this->schedule[$date][$term] = 1;
      
      // 開始時間を30分増やす
      if($start % 100 == 0){
        $start += 30;
      }else{
        $start += 70;
      }
      
      // 再帰呼び出し
      $this->putProfiles($date,$start,$finish);
    }
  }

  /**
   * 時間帯を取得する
   *
   * @param unknown_type $time
   * @return unknown $term
   * 
   * desctiption:
   * 　9時からの30分間を時間帯1、9時半からの30分間を時間帯2としたときに、引数で
   * 渡された時間で始まる時間帯がどの時間帯なのかを返す。
   */
  function getTerm($time){
    $term = intval(($time - 800) / 100) * 2 - 1;
    if($time % 100 != 0){
      $term++;
    }
    return $term;
  }
  
  /**
   * 指定された時間帯に予約か予定が入っているか調べる
   *
   * @param unknown_type $date
   * @param unknown_type $term
   * @return unknown
   */
  function getProfile($date,$term){
    if(array_key_exists($date,$this->schedule) && array_key_exists($term,$this->schedule[$date]) && $term > 0 && $term <= MAX_TERM){
      return $this->schedule[$date][$term];
    }else{
      return false;
    }
  }
  
  /**
   * 指定された日が療術を行っていない日かどうかを調べる
   *
   * @param unknown_type $date
   * @return unknown
   */
  function isClosed($date){
    for($i = 1;$i <= MAX_TERM;$i++){
      if($this->getProfile($date,$i) != 1){
        return false;
      }
    }
    return true;
  }
  
  /**
   * 年を取得する
   *
   * @return unknown
   */
  function getYear(){
    return $this->year;
  }
  
  /**
   * 月を取得する
   *
   * @return unknown
   */
  function getMonth(){
    return $this->month;
  }
  
  /**
   * 指定された日が祝日かどうか調べる
   *
   * @param unknown_type $date
   * @return unknown
   */
  function isHoliday($date){
    if(array_key_exists($date,$this->holidays)){
      return true;
    }else{
      return false;
    }
  }
  
  /**
   * 指定された時間帯が予約の始まりにあたるかどうかを調べる
   *
   * @param unknown_type $date
   * @param unknown_type $term
   * @return unknown
   */
  function isReserveStart($date,$term){
    return $this->getProfile($date,$term) == 1 && $this->getProfile($date,$term-1) != 1;
  }
  
  /**
   * 指定された時間帯が予約の終わりにあたるかどうかを調べる
   *
   * @param unknown_type $date
   * @param unknown_type $term
   * @return unknown
   */
  function isReserveFinish($date,$term){
    return ($this->getProfile($date,$term) == 1 && $this->getProfile($date,$term+1) != 1);
  }
}
?>