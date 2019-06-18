
<?php
$year = htmlspecialchars($_GET['year'], ENT_QUOTES, 'UTF-8');
$month = htmlspecialchars($_GET['month'], ENT_QUOTES, 'UTF-8');
$date = htmlspecialchars($_GET['date'], ENT_QUOTES, 'UTF-8');
$from_a0 = htmlspecialchars($_GET['from_a0'], ENT_QUOTES, 'UTF-8');
$from_a1 = htmlspecialchars($_GET['from_a1'], ENT_QUOTES, 'UTF-8');
$to_b0 = htmlspecialchars($_GET['to_b0'], ENT_QUOTES, 'UTF-8');
$to_b1 = htmlspecialchars($_GET['to_b1'], ENT_QUOTES, 'UTF-8');
$user_name = htmlspecialchars($_GET['user_name'], ENT_QUOTES, 'UTF-8');



  $y = $year;
  $m = $month;
  $d = $date;
  $s = $from_a0.$from_a1;
  $f = $to_b0.$to_b1;

 echo "$from_a0:{$from_a1}〜{$to_b0}:{$to_b1}で{$user_name}さんで追加しました";


$data = array('year' => $y, 'month' => $m, 'start' => $s, 'finish' => $f,'date' => $d);


    //IDを設定する.
if($setid == 0){
 $id = getCurrentID() + 1;
}else{
 $id = $setid;
}
    
      // ファイルを開く（追記）
$file = fopen("./data/".$data["year"].$data["month"].".dat","a");
$table_file = fopen("./data/id_table.dat","a");
    
      // レコードを作製する（ID,日付,開始時間,終了時間,予約か予定）
$record = $id.",".$data["date"].",".$data["start"].",".$data["finish"]."\n";
$table_col = $id.",".$data["year"].$data["month"]."\n";
    
      // レコードを書き込む
if(fwrite($file,$record) && fwrite($table_file,$table_col)){
  fclose($file);
  fclose($table_file);
}else{
  return ERROR;
}
  echo "レコードの作成に成功しました.";
  return $id;

function getIDTable(){
  $id_table = array();
  if(file_exists("./data/id_table.dat")){
    $file = fopen("./data/id_table.dat","r");
    while(!feof($file)){
      $line = fgetcsv($file,100000,",");
      if($line[0] != ""){
        $id_table[$line[0]] = $line[1];
      }
    }
    fclose($file);
  }
  return $id_table;
}

function getCurrentID(){
  $id_table = getIDTable();
  $current_key = 0;
  foreach($id_table as $key => $value){
    $key = intval($key);
      if($key > $current_key){
        $current_key = $key;
      }
  }
  return $current_key;
}
      
     
?>
