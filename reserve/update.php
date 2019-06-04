<?php

require_once("sys_config.php");


// POSTの内容をGETにコピーする
if(isset($_POST["mode"])){
  $_GET = $_POST;
}

if(isset($_GET["mode"])){
  // データが送られた場合
  switch($_GET["mode"]){
    case "insert":
      // データ挿入の場合
      print insertData($_GET);
      break;
    case "edit":
      // データ編集の場合
      print editData($_GET);
      break;
    case "delete":
      // データ削除の場合
      print deleteData($_GET);
      break;
    default:
      // それ以外の場合
      print ERROR;
  }
}else{
  // データが送られなかった場合
  print ERROR;
}

/**
 * 新規レコードを挿入する
 */
function insertData($data,$setid = 0){
  if(!validate($data)){
    // パラメータの妥当性を調べる
    return ERROR;
  }
  // レコードのIDを設定する
  if($setid == 0){
    $id = getCurrentID() + 1;
  }else{
    $id = $setid;
  }

  // ファイルを開く（追記）
  $file = fopen("./data/".$data["year"].$data["month"].".dat","a");
  $table_file = fopen("./data/id_table.dat","a");

  // レコードを作製する（ID,日付,開始時間,終了時間,予約か予定）
  $record = $id.",".$data["date"].",".$data["start"].",".$data["finish"]."¥n";
  $table_col = $id.",".$data["year"].$data["month"]."¥n";

  // レコードを書き込む
  if(fwrite($file,$record) && fwrite($table_file,$table_col)){
    fclose($file);
    fclose($table_file);
  }else{
    return ERROR;
  }

  return $id;
}

/**
 * レコードを編集する
 */
function editData($data){
  
  // 古いレコードを削除する
  if(!deleteData($data)){
    return ERROR;
  }

  // 新しいレコードを挿入する
  if(!insertData($data,$data["id"])){
    return ERROR;
  }

  return SUCCESS;

}

/**
 * レコードを削除する
 */
function deleteData($data){
  if(!validate($data)){
    return ERROR;
  }
  
  $table = getIDTable();

  // 既にIDが設定されているかどうか調べる
  if(!array_key_exists(intval($data["id"]),$table)){
    return ERROR;
  }
  
  // 予約情報ファイルからレコードを削除する
  $file = fopen("./data/".$table[$data["id"]].".dat","r");
  $file_lines = array();
  while(!feof($file)){
    $cols = fgetcsv($file,100000,",");
    if($cols[0] != $data["id"] && $cols[0] != ""){
      array_push($file_lines,$cols);
    }
  }
  fclose($file);
  
  $file = fopen("./data/".$table[$data["id"]].".dat","w+");
  foreach($file_lines as $line){
    fwrite($file,implode(",",$line)."¥n");
  }
  fclose($file);
  
  // ID表からレコードを削除する
  $file = fopen("./data/id_table.dat","w+");
  foreach($table as $key => $value){
    if($key != $data["id"] && $key != ""){
      fwrite($file,$key.",".$value."¥n");
    }
  }
  
  return true;

}

/**
 * 値の妥当性を調べる
 *
 * @param unknown_type $data
 * @return unknown
 */
function validate(&$data){
  if($data["mode"] != "insert"){
    if(!isset($data["id"])){
      return false;
    }
  }
  if($data["mode"] != "delete"){
    if(!isset($data["year"]) || !isset($data["month"]) || !isset($data["date"]) || !isset($data["start"]) || !isset($data["finish"])){
      return false;
    }else{
      if(!checkdate(intval($data["month"]),intval($data["date"]),intval($data["year"]))){
        return false;
      }
      if(intval($data["start"]) < START_TIME || intval($data["start"]) > FINISH_TIME || intval($data["finish"]) < START_TIME || intval($data["finish"]) > FINISH_TIME){
        return false;
      }
    }
    if($data["month"] < 10 && strlen($data["month"]) < 2){
      $data["month"] = "0".$data["month"];
    }
  }

  return true;
}

/**
 * IDと予約情報ファイル(年月)の対応表を取得する
 */
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

/**
 * 現在使われているIDの数を取得する
 */
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