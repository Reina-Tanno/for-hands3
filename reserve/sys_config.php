<?php
set_include_path("../includes" . PATH_SEPARATOR . "../includes/PEAR" . PATH_SEPARATOR . "../mobile" . PATH_SEPARATOR . "../pc" . PATH_SEPARATOR . ".." . PATH_SEPARATOR . get_include_path());
mb_internal_encoding("UTF-8");
mb_http_output("Shift_JIS");
putenv('GDFONTPATH=' . realpath('.'));

$domain = "http://www.takakusaki.info/reserve";

define("MAX_TERM",28);
define("START_TIME",900);
define("FINISH_TIME",2300);

define("MONTH_TABLE","\"calendar\"");
define("MONTH_TD","\"month\"");
define("TODAY_TD","\"today\"");
define("HOLIDAY_TD","\"holiday\"");
define("SATURDAY_TD","\"saturday\"");
define("DEFAULT_TD","\"default_td\"");
define("EMPTY_TD","\"empty_td\"");
define("CLOSED_DATE","\"closed\"");
define("DEFAULT_DATE","\"default_date\"");

define("WEEK_TABLE","\"week_table\"");
define("YEAR_MONTH_HEADER","\"head_ym\"");
define("TIME_HEADER","\"head_time\"");
define("HOLIDAY_ROW","\"hol_row\"");
define("SATURDAY_ROW","\"sat_row\"");
define("DEFAULT_ROW","\"def_row\"");
define("SELECTED_DATE_COL","\"selected\"");
define("DATE_COL","\"date\"");

define("FONT",2); // フォントのサイズ
define("J_FONT",9); // 日本語フォントのサイズ
define("J_B_FONT",11); // 日本語フォントのサイズ(大)
define("J_FONT_PATH","FS-Gothic"); // 日本語フォントへのパス
define("MONTH_FONT_PATH","month.gdf");

define("WIDTH",240); // キャンバスの幅
define("HEIGHT",140); // キャンバスの高さ
define("LEFT_X",1); // 描画を開始するX座標
define("TOP_Y",5);  // 描画を開始するY座標
define("TABLE_LEFT_X",LEFT_X + 38); // 表の描画を開始するX座標
define("TABLE_TOP_Y",TOP_Y + 10); // 表の描画を開始するY座標
define("CELL_WIDTH",14); // 表の１マスの幅
define("CELL_HEIGHT",imagefontheight(3) + 3); // 表の１マスの高さ
define("CELL_ROW",14); // 表の列数
define("CELL_COL",7); // 表の行数
define("DATE_LEFT_X",LEFT_X); // 日付の描画を開始するX座標
define("DATE_TOP_Y", TABLE_TOP_Y); // 日付の描画を開始するY座標
define("BAR_WIDTH",CELL_HEIGHT - 8); // 予約の線の幅

define("SUCCESS",1);
define("ERROR",0);

?>