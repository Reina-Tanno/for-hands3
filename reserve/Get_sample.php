
<?php

function  insertDeta(){

     require_once("sample.php");

    //IDを設定する.
      if($setid == 0){
        //$id = getCurrentID() + 1;
        $id = 13000; //今は適当に13000とする.
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


?>
