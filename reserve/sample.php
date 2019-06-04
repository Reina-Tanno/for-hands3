<!DOCTYPE html>
<html>
<head>
 <title>sample</title>
 <meta http-equiv="content-type" charset="utf-8">
</head>
<body>
<?php
  require_once("Get_sample.php");

  $y = date('Y');
  $m = date('m');
  $d = date('d');
  $s = 1000;
  $f = 1100;

  $data = array('year' => $y, 'month' => $m, 'start' => $s, 'finish' => $f,'date' => $d);

  // insertData($data,$setid = 0);
?>
<h1>テスト</h1>
<form action = 'Get_sample.php' method = 'get'>
<input type="text" name="mode" size="10">
<input type="submit" value="提出">
</from>

</boby>
</html>

