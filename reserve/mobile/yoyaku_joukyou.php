<?php
require_once("../sys_config.php");
require_once("Date/Calc.php");
require_once("Net/UserAgent/Mobile.php");


// 入力パラメータのValidateを行う
if(isset($_GET["year"]) && isset($_GET["month"]) && isset($_GET["date"])){
  if(!checkdate(intval($_GET["month"]),intval($_GET["date"]),intval($_GET["year"]))){
    // 日付情報が不正な場合
    header("Location: $domain/mobile/date.php?err=novalid");
  }else if(Date_Calc::isPastDate($_GET["date"],$_GET["month"],$_GET["year"])){
    // 過去の日付の場合
    header("Location: $domain/mobile/date.php?err=past");
  }
}else{
  // 入力パラメータが渡されていない場合
  header("Location: $domain/mobile/date.php?err=nodata");
}


// 機種ごとの表示の振り分けを行う
$agent = &Net_UserAgent_Mobile::singleton();

$format;
$font_color;
if($agent->isDocomo()){
  $format = "gif";
  $version = $agent->getHTMLVersion();
  if(isset($version)){
    if($version > 5.0){
      $font_color = "\"#FFFFFF\"";
    }else{
      $font_color = "\"#000000\"";
    }
  }else{
    $font_color = "\"#FFFFFF\"";
  }
}else if($agent->isEZweb()){
  $format = "png";
  if($agent->isXHTMLCompliant()){
    $font_color = "\"#FFFFFF\"";
  }else{
    $font_color = "\"#000000\"";
  }
}else if($agent->isVodafone()){
  $format = "png";
  $font_color = "\"#FFFFFF\"";
}else{
  $format = "png";
  $font_color = "\"#FFFFFF\"";
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>療術院予約状況</title>
</head>
<body>
<table>
 <tr>
   <td align="center"><font size="1">たかくさき療術院</font><br></td>
 </tr>
 <tr>
   <? print "<td bgcolor=\"#DD0000\"><font color=". $font_color ." size=\"1\">予約状況</font><br></td>"; ?>
 </tr>
 <tr>
   <td>
     <? print "<img src=\"image.php?year=". $_GET["year"] ."&month=". $_GET["month"] ."&date=". $_GET["date"] ."&format=". $format ."\">"; ?>
   </td>
 </tr>
 <tr>
	<? print "<td bgcolor=\"#DD0000\"><font color=". $font_color ." size=\"1\">参照日選択</font><br></td>"; ?>
	</tr>
	<tr>
		<td><font size=1>参照したい日付を選択してください。</font><br></td>
	</tr>


	<?php
	if($_GET["err"] == "nodata"){
	  print "<tr><td><font color=\"#FF0000\" size=\"1\">日付を入力してください。</font><br></td></tr>";
	}else if($_GET["err"] == "novalid"){
	  print "<tr><td><font color=\"#FF0000\" size=\"1\">日付の値が正しくありません。</font><br></td></tr>";
	}else if($_GET["err"] == "past"){
	  print "<tr><td><font color=\"#FF0000\" size=\"1\">過去の日付が選択されています。</font><br></td></tr>";
	}
	?>
	<tr>
		<td>
		<form method="GET" action="yoyaku_joukyou.php"><?php
		print "<input type=\"text\" maxlength=\"4\" size=\"4\" name=\"year\" value=" . date('Y') . " istyle=\"4\" mode=\"numeric\">年<br>\n";
		print "<input type=\"text\" maxlength=\"2\" size=\"2\" name=\"month\" value=" . date('m') . " istyle=\"4\" mode=\"numeric\">月";
		print "<input type=\"text\" maxlength=\"2\" size=\"2\" name=\"date\" value=" . date('d') . " istyle=\"4\" mode=\"numeric\">日<br>\n";
		?> <input type="submit" value="参照"></form>
		</td>
	</tr>
</table>
</body>
</html>