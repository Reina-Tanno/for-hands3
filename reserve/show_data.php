<?php
    require_once('pdo.php');

    try {
        $dbh = new PDO('mysql:host=localhost;dbname=Customers;charset=utf8mb4;','root','akogi0304');
        $sql = "SELECT * FROM customers WHERE date_format(reserve_date,'%Y%m') = '201907'";  //2019年の7月を抽出.
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $list[] = $stmt->fetchAll();

        if(empty($list[0])){
            $list[0] = '予定なし';
            //echo '6月1日に予定が入っていません.';
        } else {
            $list[0] = '予定あり';
            //echo '6月1日に予定は入っています';
        }


        } catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
    }


?>
