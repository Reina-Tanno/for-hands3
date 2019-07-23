<?php

session_start();

$dsn = "mysql:dbname=Customers;host=133.2.113.160";  // DBサーバのURL
$user = "root";  // ユーザー名
$password = "akogi0304";  // ユーザー名のパスワード

if(isset($_POST[login])){
    echo 'でけた！';
try {
    $dbh = new PDO('mysql:host=localhost;dbname=Customers;charset=utf8mb4;','root','akogi0304');
    echo '接続成功';
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}


}

?>
<!doctype html>

<html>

    <head>
        <meta charset="utf-8">
        <!-- <link rel="stylesheet" href="reserve.css" type="text/css"> -->
    </head>

    <body>


 <button id="1_9"> </button>

   
                <div id="reserve_click">
                </div>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
        </script>
        <script src="https://rawgithub.com/kangax/fabric.js/master/dist/fabric.js"></script>
        <script type="text/javascript">


            //1_9を押すと、そのセルの位置を取得し、drawの引数に置く.
            document.getElementById("1_9").onclick = function () {
                document.getElementById('reserve_click').innerHTML = '<form id="loginForm" name="loginForm" method="POST" action=""> <input type="submit" id="login" name="login" value="ログイン"></form>';
            }



        </script>
    </body>

</html>