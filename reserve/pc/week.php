<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<style = "text/css">
<!--
body{
  font-size:12pt;
}

.right{
  text-align:center;
}

.container{
  width:80%;
  margin:0px auto;
  text-align:left;
}

.text{
  margin:20px 0px;
}

h1{
  font-size:12pt;
  font-weight:normal;
  display:block;
  margin:10px 0px;
}

table {
  border-collapse:collapse;
  margin:10px 0px;
}

table tr td{
  margin:0px;
  padding:0px;
  text-align:center;
  border-style:solid;
  border-color:#aaaaaa;
  border-top-width:1px;
  border-bottom-width:1px;
  border-left-width:0px;
  border-right-width:0px;
  font-size:0.8em;
}

.date{
  border-left-width:1px;
  border-right-width:1px;
  padding:0px 3px;
}

.selected{
  font-weight:bold;
  border-left-width:1px;
  border-right-width:1px;
  padding:0px 3px;
}

.head_ym th{
  padding:20px 0px;
  border-style:none;
  font-size:14pt;
  font-weight:bold;
}

.head_time td{
  background-image:URL("images/time_back.gif");
}

.hol_row{
  background-color:#ffcccc;
}

.sat_row{
  background-color:#eeeeee;
}

.def_row{
  background-color:#f5ffff;
}

.list{
  list-style:none;
  margin:0px;
  padding:0px;
}


-->
</style>
</head>
<body>
<div class="right">

<div class="container">

<h1>予約状況参照</h1>

<div class="text">
<p>左のカレンダーから参照したい時間帯をお選びください。</p>

<ul class="list">
  <li>＊ 療術を行っていない日は選択できません。</li>
  <li>＊ 棒線の入った時間帯はすでに予約が入っている時間帯です。</li>
  <li>＊ 1時間半以上の空きがある時間帯から予約をお受けいたします。</li>
</ul>
</div>

<?php
require_once("../sys_config.php");
require_once("WeeklyCalendarFactory.class.php");

// 週別予約状況表を表示する
if(isset($_GET["year"]) && isset($_GET["month"]) && isset($_GET["date"])){
  $week = new WeeklyCalendarFactory($_GET["year"],$_GET["month"],$_GET["date"]);
}else{
  $week = new WeeklyCalendarFactory(date('Y'),date('m'),date('j'));
}
$week->draw();

?>


</div>
</div>
</body>
</html>