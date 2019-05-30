<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<style type="text/css">
<!--
.left{
  text-align:center;
}
.left table{
  margin:10px auto;
  border-collapse:collapse;
}

.left table tr td{
  text-align:center;
  vertical-align:middle;
  border:1px solid #aaaaaa; 
  font-size:0.8em;
  margin:0px;
  padding:3px;
}

a:link{  color:#0000FF;text-decoration:none;  }
a:hover{  color:#FFFF00;text-decoration:none;  }
a:active{  color:#0000FF;text-decoration:none;  }
a:visited{  color:#0000FF;text-decoration:none;  }

.holiday{
  background-color:#ffcccc;
}

.saturday{
  background-color:#eeeeee;
}

.today{
  font-weight:bold;
  background-color:#ffff00;
}

.default_td{
  background-color:#f5ffff;
}

.empty_td{
  background-color:#ffffff;
}

.closed{
  color:#cccccc;
}

-->
</style>
</head>
<body>
<div class="container">

<div class="left">

<?php
require_once("../sys_config.php");
require_once("MonthlyCalendarFactory.class.php");

$year = intval(date("Y"));
$month = intval(date("m"));
$date = intval(date("j"));

for($i = 0;$i < 3;$i++){
  if($i == 0){
    $calendar = new MonthlyCalendarFactory($year,$month,$date);
  }else{
    $calendar = new MonthlyCalendarFactory($year,$month);
  }
  $calendar->draw();
  
  $month += 1;
  if($month > 12){
    $month -= 12;
    $year++;
  }
}

?>

</div>
</body>
</html>