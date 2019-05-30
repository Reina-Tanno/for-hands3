<?php

/**
 * 週別予約状況表の画像ファイルを返す
 */

require_once("../sys_config.php");
require_once("WeeklyCalendarImageFactory.class.php");
require_once("../Logger.class.php");

// 返す画像のフォーマットを指定する
$format;
if(isset($_GET["format"])){
  $format = $_GET["format"];
}
if($format == "gif"){
  header("Content-type: image/gif");
}else{
  header("Content-type: image/png");
}

// 返す画像を作成する
$factory;
if(isset($_GET["year"]) && isset($_GET["month"]) && isset($_GET["date"])){
  $factory = new WeeklyCalendarImageFactory(intval($_GET["year"]),intval($_GET["month"]),intval($_GET["date"]));
}else{
  $factory = new WeeklyCalendarImageFactory(date("Y"),$date("m"),date("j"));
}

$image = $factory->getImage();

// 画像を返す
if($format == "gif"){
  imagegif($image);
}else{
  imagepng($image);
}

imagedestroy($image);

?>