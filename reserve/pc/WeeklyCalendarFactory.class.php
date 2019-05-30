<?php
require_once("../sys_config.php");
require_once("Calendar/Week.php");
require_once("MonthlyScheduleManager.class.php");

/**
 * 週別予約状況表を作成・表示するクラス
 * for PC Browser
 */
class WeeklyCalendarFactory{
  var $year;
  var $month;
  var $date;
  var $schedule;
  var $next_schedule;
  var $day_of_week = array("日","月","火","水","木","金","土");

  function WeeklyCalendarFactory($year, $month, $date){
    $this->year = $year;
    $this->month = $month;
    $this->date = $date;
  }

  function draw(){
    $table = WEEK_TABLE;
    $head_ym = YEAR_MONTH_HEADER;
    $head_time = TIME_HEADER;
    $hol_row = HOLIDAY_ROW;
    $sat_row = SATURDAY_ROW;
    $def_row = DEFAULT_ROW;
    $selected_date_col = SELECTED_DATE_COL;
    $date_col = DATE_COL;
    

    $week = new Calendar_Week($this->year, $this->month, $this->date, 0);
    $week->build();

    
    print "<table border=\"0\" class=$table>\n";
    print "<tr class=$head_time><td style=\"border-left-width:1px;border-right-width:1px;\"><img src=\"images/time_space.png\"></td>\n";
    for($i = 0;$i < MAX_TERM + 1;$i++){
      // 時間を表示
      if($i % 2 == 0){
        $time = 9 + ($i / 2);
        if($i < MAX_TERM){
          print "<td colspan=\"2\">".$time.":00</td>\n";
        }else{
          print "<td colspan=\"2\" style=\"border-right-width:1px;\">".$time.":00</td>\n";
        }
      }
    }
    print "</tr>\n";

    // 週別予定表を表示する
    for($i = 0;$day = $week->fetch();$i++){
      if($this->schedule == null){
        // 最初に月ごとの予定を取得する
        $this->schedule = new MonthlyScheduleManager($day->thisYear(),$day->thisMonth());
      }else if($this->schedule->getMonth() != $day->thisMonth()){
        // 月をまたいだときに次の月の予定を取得する
        $this->schedule = new MonthlyScheduleManager($day->thisYear(),$day->thisMonth());
      }
      
      if($i == 0 || $this->schedule->isHoliday($day->thisDay())){
        // 休日のとき
        print "<tr class=$hol_row>\n";
      }else if($i == 6){
        // 土曜のとき
        print "<tr class=$sat_row>\n";
      }else{
        // 平日のとき
        print "<tr class=$def_row>\n";
      }

      // 日付を表示
      if($day->thisMonth() == $this->month && $day->thisDay() == $this->date){
        print "<td class=$selected_date_col>".$day->thisMonth()."/".$day->thisDay()."(".$this->day_of_week[$i].")</td>\n";
      }else{
        print "<td class=$date_col>".$day->thisMonth()."/".$day->thisDay()."(".$this->day_of_week[$i].")</td>\n";
      }
      print "<td style=\"border-right-width:1px;\"><img src=\"images/no_ap_line.png\"></td>\n";

      for($term = 1; $term <= MAX_TERM + 1; $term++){
        if($term % 2 == 0 || $term == MAX_TERM + 1){
          // 時間ごとの区切り線
          print "<td style=\"border-right-width:1px\">";
        }else{
          print "<td>";
        }

        if($this->schedule->getProfile($day->thisDay(),$term)){
          // 予約や予定が入っているとき
          print "<img src=\"images/ap_line.png\">";
        }else{
          // 空いているとき
          print "<img src=\"images/no_ap_line.png\">";
        }
      }

      print "</td></tr>\n";
    }

    print "</table>\n";
  }
}