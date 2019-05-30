<?php
require_once("../sys_config.php");
require_once("Calendar/Week.php");
require_once("MonthlyScheduleManager.class.php");
require_once("Logger.class.php");

/**
 * 週別予約状況表の画像を作成するクラス
 * 
 * description:
 * 　携帯電話での週別予約状況参照のために、週ごとの予約状況を表形式にして描画した画像リソースを出力する。
 * このクラスを呼び出す側は、出力された画像リソースから、フォーマットにしたがって画像の生成を行う。
 */
class WeeklyCalendarImageFactory{

  var $year;
  var $month;
  var $date;
  var $logger;

  function WeeklyCalendarImageFactory($year,$month,$date,$logger = null){
    $this->year = $year;
    $this->month = $month;
    $this->date = $date;
    if(isset($logger)){
      $this->logger = $logger;
    }
  }

  /**
   * 画像を描画して取得する
   *
   */
  function getImage(){

    // キャンバスを作成
    $image = imagecreate(WIDTH,HEIGHT);

    // 背景色を設定
    $background = imagecolorallocate($image, 255, 255, 255);

    // 枠組みとなる表を描画する
    $this->drawTable($image);

    // 日付の表示を描画する
    $this->drawDate($image);

    // 選択された日付に強調枠を描画する
    $this->drawAccentFrame($image);

    // 予約が入っているところに線を描画する
    $this->drawReserveBar($image);

    return $image;
  }

  /**
   * 枠組みとなる表を描画する
   *
   * @param unknown_type $image
   */
  function drawTable(&$image){
    // 色情報を作成
    $black = imagecolorallocate($image, 0, 0, 0);


    // 表の上に時間を描画する
    $y = TABLE_TOP_Y - (imagefontheight(3) + 1);
    for($i = 0;$i < 5;$i++){
      $time = 9 + $i * 3;
      $fontwidth = imagefontwidth(3);
      if($time >= 10){
        $fontwidth *= 2;
      }
      $x = TABLE_LEFT_X + (CELL_WIDTH * 3 * $i) - intval($fontwidth / 2);
      imagestring($image, FONT, $x, $y, $time, $black);
    }



    // 表の横線を描画する
    for ($i = 0; $i < CELL_COL + 1; $i++) {
      $base = CELL_HEIGHT * $i;
      imageline($image,TABLE_LEFT_X, TABLE_TOP_Y + $base, TABLE_LEFT_X + (CELL_ROW * CELL_WIDTH), TABLE_TOP_Y + $base,$black);
    }

    // 表の縦線を描画する
    for ($i = 0; $i < CELL_ROW + 1; $i++) {
      $base = CELL_WIDTH * $i;
      imageline($image,TABLE_LEFT_X + $base, TABLE_TOP_Y, TABLE_LEFT_X + $base, TABLE_TOP_Y + (CELL_COL * CELL_HEIGHT), $black);
    }

    // 表の縦破線を描画する
    for ($i = 0; $i < CELL_ROW; $i++) {
      $base = CELL_WIDTH * $i;
      imagedashedline($image,TABLE_LEFT_X + $base + (CELL_WIDTH / 2), TABLE_TOP_Y, TABLE_LEFT_X + $base + (CELL_WIDTH / 2), TABLE_TOP_Y + (CELL_COL * CELL_HEIGHT),$black);
    }

  }

  /**
   * 日付の表示を描画する
   *
   * @param unknown_type $image
   */
  function drawDate(&$image){
    // 色情報を作成
    $black = imagecolorallocate($image,0,0,0);
    $red = imagecolorallocate($image,255,0,0);
    $blue = imagecolorallocate($image,0,0,255);

    // その日を含む週別のカレンダーを取得
    $week = new Calendar_Week($this->year, $this->month, $this->date, 0);
    $week->build();

    $schedule = null;
    $start_month = null;
    $day = null;
    for($i = 0;$i < 7;$i++){
      $day = $week->fetch();
      if(!isset($schedule)){
        // 最初に月ごとの予定を取得する
        $schedule = new MonthlyScheduleManager($day->thisYear(),$day->thisMonth());
      }else if($schedule->getMonth() != $day->thisMonth()){
        // 月をまたいだときに次の月の予定を取得する
        $schedule = new MonthlyScheduleManager($day->thisYear(),$day->thisMonth());
      }
      // 週の最初のの月を取得する
      $start_month = $day->thisMonth();

      // 休日・土曜日・平日で色分けをする
      $color;
      if($i == 0 || $schedule->isHoliday($day->thisDay())){
        // 休日の時
        $color = $red;
      }else if($i == 6){
        // 土曜日のとき
        $color = $blue;
      }else{
        // 平日のとき
        $color = $black;
      }

      // 日付を描画する
      $date_x = DATE_LEFT_X;
      $date_y = DATE_TOP_Y + ($i * CELL_HEIGHT + 1);
      imagestring($image,FONT+1,$date_x,$date_y, $day->thisMonth() . "/" . $day->thisDay(),$color);
    }
  }

  /**
   * 選択された日付に強調枠を表示する
   *
   * @param unknown_type $image
   */
  function drawAccentFrame(&$image){

    // 色情報を作成
    $green = imagecolorallocate($image,0, 200, 0);

    // その日を含む週別のカレンダーを取得
    $week = new Calendar_Week($this->year, $this->month, $this->date, 0);
    $week->build();

    for($i = 0;$day = $week->fetch();$i++){
      if($day->thisMonth() == $this->month && $day->thisDay() == $this->date){
        // 強調枠を表示する
        imagerectangle($image,TABLE_LEFT_X, TABLE_TOP_Y + (CELL_HEIGHT * $i), TABLE_LEFT_X + (CELL_ROW * CELL_WIDTH), TABLE_TOP_Y + (CELL_HEIGHT * ($i + 1)),$green);
        imagerectangle($image,TABLE_LEFT_X - 1, TABLE_TOP_Y + (CELL_HEIGHT * $i) - 1, TABLE_LEFT_X + (CELL_ROW * CELL_WIDTH) + 1, TABLE_TOP_Y + (CELL_HEIGHT * ($i + 1)) + 1,$green);
      }
    }
  }

  /**
   * 予約が入っているところに線を描画する
   *
   * @param unknown_type $image
   */
  function drawReserveBar(&$image){
    // 色情報を作成
    $blue = imagecolorallocate($image,0, 0, 255);

    // その日を含む週別のカレンダーを取得
    $week = new Calendar_Week($this->year, $this->month, $this->date, 0);
    $week->build();

    $schedule = null;

    for($i = 0;$day = $week->fetch();$i++){
      if(!isset($schedule)){
        // 最初に月ごとの予約状況を取得する
        $schedule = new MonthlyScheduleManager($day->thisYear(),$day->thisMonth());
      }else if($schedule->getMonth() != $day->thisMonth()){
        // 週の中で月をまたいだときに次の月の予約状況を取得する
        $schedule = new MonthlyScheduleManager($day->thisYear(),$day->thisMonth());
      }
      for($term = 1;$term <= MAX_TERM;$term++){
        if($schedule->getProfile($day->thisDay(),$term)){
          // 予約が入っているとき
          $x = TABLE_LEFT_X + (CELL_WIDTH / 2) * ($term - 1);
          $y = TABLE_TOP_Y + (CELL_HEIGHT - BAR_WIDTH) / 2 + (CELL_HEIGHT * $i);
          imagefilledrectangle($image, $x, $y, $x + (CELL_WIDTH / 2),$y + BAR_WIDTH,$blue);
        }
      }
    }
  }
}
?>