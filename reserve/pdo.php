<?php

session_start();
require_once('show_data.php');
$errorMessage = "";


//データを消す処理.
if(isset($_POST[del])){
    $year = $_POST["year"]; //postされた年.
    $month = $_POST["month"]; //postされた月.
    $date = $_POST["date"]; //postされた日にち.
    $start_h = $_POST["start_h"];//9,12
    $finish_h = $_POST["finish_h"];

    if($month < 10 && $date < 10){
        $del_reserve_date =(string)$year.'0'.(string)$month.'0'.(string)$date;
    }else if($month < 10){
        $del_reserve_date =(string)$year.'0'.(string)$month.(string)$date;
    }else if($date < 10){
        $del_reserve_date =(string)$year.(string)$month.'0'.(string)$date;
    }

    $del_start_time =(string)$start_h.'0'.'0'.'0'.'0';

    try {
    	$dbh = new PDO('mysql:host=127.0.0.1;dbname=Customers;charset=utf8mb4;','root','akogi0304');
        $sql = "DELETE FROM customers WHERE reserve_date = :reserve_date and start_time = :start_h";
        $prepare = $dbh->prepare($sql);
        $prepare->bindValue(':reserve_date', $del_reserve_date, PDO::PARAM_INT);
        $prepare->bindValue(':start_h', $del_start_time, PDO::PARAM_INT);
        $prepare->execute();
        $alert = "<script type='text/javascript'>alert('消しました');</script>"; //table全部消えちゃう.
        echo $alert;
        exit();

    } catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
    }

}


if(isset($_POST[sub])){ //もしsubがPOSTされたらdbに接続,insertする.

    // $now = date('Y/m/d ˙H:i:s');//POSTされた時間を取得.  update_timeに入れる.
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
    } else if (empty($_POST["start_h"]) || empty($_POST["start_m"])) {
        $alert = "<script type='text/javascript'>alert('タイトルが入力されていません');</script>"; //追加
        echo $alert;
    } else if (empty($_POST["finish_h"]) || empty($_POST["finish_m"])) {
        $alert = "<script type='text/javascript'>alert('タイトルが入力されていません');</script>";//追加
        echo $alert;
    }
    
    if (!empty($_POST["year"]) && !empty($_POST["month"]) && !empty($_POST["date"]) && !empty($_POST["title"]) && !empty($_POST["start_h"]) && !empty($_POST["start_m"]) && !empty($_POST["finish_h"]) && !empty($_POST["finish_m"])) {
        $year = $_POST["year"]; //postされた年.
        $month = $_POST["month"]; //postされた月.
        $date = $_POST["date"]; //postされた日にち.
        $title = $_POST["title"]; //postされたタイトル.
        $start_h = $_POST["start_h"];
        $start_m = $_POST["start_m"];
        $finish_h = $_POST["finish_h"];
        $finish_m = $_POST["finish_m"];

        $start = (string)$start_h.(string)$start_m.'00';
        $finish = (string)$finish_h.(string)$finish_m.'00';


        //それぞれ文字列に変換したのち,&monthと$dateが一桁だった場合、その数字の前に'0'を足す.
        if($month<10 && $date<10){
            $reserve_date = (string)$year.'0'.(string)$month.'0'.(string)$date;
        } else if ($month<10 && $date>10){
            $reserve_date = (string)$year.'0'.(string)$month. (string)$date;
        } else if ($month>10 && $date<10){
            $reserve_date = (string)$year.(string)$month.'0'.(string)$date;
        } else {
            $reserve_date = (string)$year.(string)$month.(string)$date;
        }

        try {
	        $dbh = new PDO('mysql:host=127.0.0.1;dbname=Customers;charset=utf8mb4;','root','akogi0304');
            $sql = "INSERT INTO customers (title, reserve_date, start_time, finish_time, comment) VALUES (:title, :reserve_date, :start_time, :finish_time, :comment)";
            $prepare = $dbh->prepare($sql); $prepare->bindValue(':title', $title, PDO::PARAM_STR);
            $prepare->bindValue(':reserve_date', $reserve_date, PDO::PARAM_INT);
            $prepare->bindValue(':start_time', $start , PDO::PARAM_INT);
            $prepare->bindValue(':finish_time', $finish , PDO::PARAM_INT);
            $prepare->bindValue(':comment', 'comment', PDO::PARAM_STR);
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

require('reserve.php');

?>


