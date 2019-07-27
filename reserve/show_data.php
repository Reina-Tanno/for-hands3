<?php

    try {

        $year = $_POST["yeara"];
        $month=$_POST["month"];


	    $reserve_ym = (string)$ydate.(string)$mdate; //reserve.phpで宣言された月.
        //特定の年月のデータを抽出.
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=Customers;charset=utf8;','root','akogi0304');
        $sql = "SELECT * FROM customers WHERE date_format(reserve_date,'%Y%m') = '201907'";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stack = array(); //日にちを入れる箱.
        $stack_start = array(); //開始時間を入れる箱.
        $stack_title = array(); //タイトルを入れる箱.

        foreach ($list as $row) {
            for($i = 1; $i < 16; $i++){
                if($row['reserve_date'] == '2019-07-0'.$i){ //20190701~20190709

                    for($k = 9; $k < 24; $k++){
                        if($row['start_time'] == '0'.$k.':00:00'){
                            array_push($stack,$i);
                            array_push($stack_start,$k);
                            array_push($stack_title, $row['title']);
                        } else if ($row['start_time'] == $k.':00:00'){ //09:00:00
                            array_push($stack,$i);
                            array_push($stack_start,$k);
                            array_push($stack_title, $row['title']);
                        }
                    }
                            //iが入っている日にちなので、それぞれの変数に格納する.
                }else if($row['reserve_date'] == '2019-07-'.$i){//20190710~20190715
                    for($k = 9; $k < 24; $k++){
                        if($row['start_time'] == '0'.$k.':00:00'){
                            array_push($stack,$i);
                            array_push($stack_start,$k);
                            array_push($stack_title, $row['title']);
                        }
                        else if($row['start_time'] == $k.':00:00'){ //09:00:00
                            array_push($stack,$i);
                            array_push($stack_start,$k);
                            array_push($stack_title, $row['title']);
                        }
                    }
                }
            }
	    }

        $stack_from_php = json_encode($stack);
        // var_dump($stack_from_php);

        $stack_start_from_php = json_encode($stack_start);
        // var_dump($stack_start_from_php);

        $stack_title_from_php = json_encode($stack_title);
        // var_dump($stack_start_from_php);

	} catch (PDOException $e) {
        echo "接続失敗: " . $e->getMessage() . "\n";
        exit();
    }
    require_once('pdo.php');
    require_once('reserve.php');
?>