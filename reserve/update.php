<?php

require_once("sys_config.php");


// POST�����Ƥ�GET�˥��ԡ�����
if(isset($_POST["mode"])){
  $_GET = $_POST;
}

if(isset($_GET["mode"])){
  // �ǡ���������줿���
  switch($_GET["mode"]){
    case "insert":
      // �ǡ��������ξ��
      print insertData($_GET);
      break;
    case "edit":
      // �ǡ����Խ��ξ��
      print editData($_GET);
      break;
    case "delete":
      // �ǡ�������ξ��
      print deleteData($_GET);
      break;
    default:
      // ����ʳ��ξ��
      print ERROR;
  }
}else{
  // �ǡ����������ʤ��ä����
  print ERROR;
}

/**
 * �����쥳���ɤ���������
 */
function insertData($data,$setid = 0){
  if(!validate($data)){
    // �ѥ�᡼������������Ĵ�٤�
    return ERROR;
  }
  // �쥳���ɤ�ID�����ꤹ��
  if($setid == 0){
    $id = getCurrentID() + 1;
  }else{
    $id = $setid;
  }

  // �ե�����򳫤����ɵ���
  $file = fopen("./data/".$data["year"].$data["month"].".dat","a");
  $table_file = fopen("./data/id_table.dat","a");

  // �쥳���ɤ���������ID,����,���ϻ���,��λ����,ͽ��ͽ���
  $record = $id.",".$data["date"].",".$data["start"].",".$data["finish"]."\n";
  $table_col = $id.",".$data["year"].$data["month"]."\n";

  // �쥳���ɤ�񤭹���
  if(fwrite($file,$record) && fwrite($table_file,$table_col)){
    fclose($file);
    fclose($table_file);
  }else{
    return ERROR;
  }

  return $id;
}

/**
 * �쥳���ɤ��Խ�����
 */
function editData($data){
  
  // �Ť��쥳���ɤ�������
  if(!deleteData($data)){
    return ERROR;
  }

  // �������쥳���ɤ���������
  if(!insertData($data,$data["id"])){
    return ERROR;
  }

  return SUCCESS;

}

/**
 * �쥳���ɤ�������
 */
function deleteData($data){
  if(!validate($data)){
    return ERROR;
  }
  
  $table = getIDTable();

  // ����ID�����ꤵ��Ƥ��뤫�ɤ���Ĵ�٤�
  if(!array_key_exists(intval($data["id"]),$table)){
    return ERROR;
  }
  
  // ͽ�����ե����뤫��쥳���ɤ�������
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
    fwrite($file,implode(",",$line)."\n");
  }
  fclose($file);
  
  // IDɽ����쥳���ɤ�������
  $file = fopen("./data/id_table.dat","w+");
  foreach($table as $key => $value){
    if($key != $data["id"] && $key != ""){
      fwrite($file,$key.",".$value."\n");
    }
  }
  
  return true;

}

/**
 * �ͤ���������Ĵ�٤�
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
 * ID��ͽ�����ե�����(ǯ��)���б�ɽ���������
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
 * ���߻Ȥ��Ƥ���ID�ο����������
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