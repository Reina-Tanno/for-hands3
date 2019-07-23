<?php

session_start();
require_once('show_data.php');
require_once('reserve.php');

$errorMessage = "";

if(isset($_POST[sub])){ //もしsubがPOSTされたらdbに接続,insertする.


    var_dump(isset($$_POST[del]));
    $now = date('Y/m/d ˙H:i:s');//POSTされた時間を取得.  update_timeに入れる.
    if (empty($_POST["year"])) {  
        $alert = "<script type='text/javascript'>alert('年が入力されていません');</script>";
        echo $alert;
    } else if (empty($_POST["month"])) {
        $alert = "<script type='text/javascript'>alert('月が入力されていません');</script>";
        echo $alert;
    } else if (empty($_POST["date"])) {
        $alert = "<script type='text/javascript'>alert('日にちが入力されていません');</script>";
        echo $alert;
    } else if (empty($_POST["title"])) {
        $alert = "<script type='text/javascript'>alert('タイトルが入力されていません');</script>";
        echo $alert;
    }

    if (!empty($_POST["year"]) && !empty($_POST["month"]) && !empty($_POST["date"]) && !empty($_POST["title"])) {
        $year = $_POST["year"];
        $month = $_POST["month"];
        $date = $_POST["date"];
        $title = $_POST["title"];


        //それぞれ文字列に変換したのち,&monthと$dateが一桁だった場合、その数字の前に'0'を足す.
        if($month<10 && $date<10){
            $reserve_date = (string)$year.'0'.(string)$month.'0'.(string)$date;
        } else if($month<10 && $date>10){
            $reserve_date = (string)$year.'0'.(string)$month. (string)$date;
        } else if($month>10 && $date<10){
            $reserve_date = (string)$year.(string)$month.'0'.(string)$date;
        } else {
            $reserve_date = (string)$year.(string)$month.(string)$date;
        }
        


    try {
        $dbh = new PDO('mysql:host=localhost;dbname=Customers;charset=utf8mb4;','root','akogi0304');
        $sql = "INSERT INTO customers (title, reserve_date, start_time, finish_time, comment) VALUES (:title, :reserve_date, :start_time, :finish_time, :comment)"; 
        $prepare = $dbh->prepare($sql); $prepare->bindValue(':title', $title, PDO::PARAM_STR);
        $prepare->bindValue(':reserve_date', $reserve_date, PDO::PARAM_INT); 
        $prepare->bindValue(':start_time', '090000', PDO::PARAM_INT);  
        $prepare->bindValue(':finish_time', '100000', PDO::PARAM_INT); 
        $prepare->bindValue(':comment', 'yagi', PDO::PARAM_STR); 
        $prepare->execute(); 

        $sql = "SELECT * FROM customers WHERE date_format(reserve_date,'%Y%m') = '201907'";  //2019年の7月を抽出.
        $prepare = $dbh->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);
        exit(); 

    } catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
    }
}
     

}


else if(isset($_POST[del])){ //もしdelがPOSTされたら,truncate.
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=Customers;charset=utf8mb4;','root','akogi0304');
        $sql = "TRUNCATE TABLE customers"; 
        $prepare = $dbh->prepare($sql); 
        $prepare->execute(); 
        $alert = "<script type='text/javascript'>alert('消しました');</script>"; //table全部消えちゃう.
        echo $alert;
        exit(); 

    } catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
    }

}


?>