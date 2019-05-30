<?php
require_once("../sys_config.php");
require_once("Calendar/Month/Weekdays.php");
require_once("MonthlyScheduleManager.class.php");

/**
 * カレンダーを作成・表示するクラス
 */
class MonthlyCalendarFactory{
  var $year = 0;
  var $month = 0;
  var $date = 0;
  var $schedule;

  function MonthlyCalendarFactory($year,$month,$date = 0){
    $this->year = $year;
    $this->month = $month;
    $this->date = $date;
    $this->schedule = new MonthlyScheduleManager($year,$month);
  }

  function draw(){
    $table = MONTH_TABLE;
    $month_td = MONTH_TD;
    $today_td = TODAY_TD;
    $hol_td = HOLIDAY_TD;
    $sat_td = SATURDAY_TD;
    $def_td = DEFAULT_TD;
    $emp_td = EMPTY_TD;
    $closed_date = CLOSED_DATE;
    $default_date = DEFAULT_DATE;

    $Month = new Calendar_Month_Weekdays($this->year, $this->month, 0);

    $Month->build();

    // テーブルを作る
    $thismonth = $this->month;
    echo "<table class=$table>\n";
    echo "<tr><td colspan=\"7\" class=$month_td > $thismonth";
    echo "月 </td></tr>";
    
    //曜日の列
    echo "<tr><td class=$hol_td>日</td>";
    echo "<td class=$def_td>月</td>";
    echo "<td class=$def_td>火</td>";
    echo "<td class=$def_td>水</td>";
    echo "<td class=$def_td>木</td>";
    echo "<td class=$def_td>金</td>";
    echo "<td class=$sat_td>土</td></tr>";

    while ($Day = $Month->fetch()) {
      if ($Day->isFirst()) {
        echo "<tr>";
      }

      if ($Day->isEmpty()) {
        // 空欄のとき
        echo "<td class=$emp_td>&nbsp;</td>\n";
      } else {
        if($Day->thisDay() == $this->date){
          // 今日のとき
          echo "<td class=$today_td>";
        }else if ($Day->isFirst() || $this->schedule->isHoliday($Day->thisDay())) {
          // 休日のとき
          echo "<td class=$hol_td>";
        }else if($Day->isLast()){
          // 土曜のとき
          echo "<td class=$sat_td>";
        }else{
          // 平日のとき
          echo "<td class=$def_td>";
        }
        
        if($this->schedule->isClosed($Day->thisDay())){
          // 療術を行っていないとき
          echo "<span class=$closed_date>".$Day->thisDay()."</span></td>\n";
        }else{
          // 通常のとき
          echo "<a href=\"yoyaku_joukyou.php?year=".$Day->thisYear()."&month=".$Day->thisMonth().
              "&date=".$Day->thisDay()."\" class=$default_date>" .$Day->thisDay()."</a></td>\n";
        }

        if ($Day->isLast()) {
          echo "</tr>\n";
        }
      }
    }

    echo "</table>\n";
  }
}

?>
