<?php

session_start();

$dsn = "mysql:dbname=Customers;host=133.2.113.160";  // DBサーバのURL
$user = "root";  // ユーザー名
$password = "akogi0304";  // ユーザー名のパスワード

try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=Members;charset=utf8;','root','emika0304');
    echo '接続成功';
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}





?>
<!doctype html>
<html>
 
    <head>
        <meta charset="UTF-8"> 
    </head>
    <body>

        <h1 id="year">年</h1><h1 id="month"></h1> 
            <div id="content">
                <table>
                    <th id="date"></th><th id="day"></th><th></th><th></th><th></th><th></th><th></th>
                        <tb>

                </table>
            
            </div>

        
    </body>
</html>
