<?php

session_start();

?>

<!doctype html>

<html>

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="reserve.css" type="text/css">
    </head>

    <?php
        require_once('show_data.php');
        $ydate = date("Y");
        $mdate = date("m");
    ?>

        <body>
            <form name="yearmonth" method="POST" action="">
                <div id="year">
                    <?php echo $ydate?>年</div>
                <input type="hidden" id="yeara" name="yeara" value='anan'>
                <!-- この画面の年はこのydateに格納する、あとで加工必要あり. -->
                <div id="month">
                    <?php echo $mdate?>月</div>
                <input type="hidden" name="month" value='+<?php echo $mdate?>+'>
            </form>
            <!-- この画面の年はこのmdateに格納する、あとで加工必要あり. -->
            <div id="content">

                <table class="table_table" id="table">

                    <div id="reserve_click"></div>

                    <thead id="theadID"></thead>
                    <tbody id="tbodyID"></tbody>

                </table>

            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script type="text/javascript">

                var alpha = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o'];

                //table作成.
                var thead = document.getElementById('theadID');
                var th_item = '';
                for (var i = 9; i < 23; i++) {
                    var th_item = th_item + '<th>' + i + ':00</th>';
                }
                thead.innerHTML = '<tr><th class="date"></th><th id="day"></th>' + th_item + '<th>備考</th>';
                var tbody = document.getElementById('tbodyID');
                for (var k = 0; k < 15; k++) {
                    var td_item = '';
                    for (var m = 9; m < 24; m++) {
                        var mm = parseInt(m) - 8;
                        var td_item = td_item + '<td class="td" id="' + alpha[k] + '_' + m + '"></td>';
                    }
                    var kk = parseInt(k) + 1;
                    var tbody_item = '<tr><th>' + kk + '</th><td></td>' + td_item + '';
                    tbody.innerHTML += tbody_item;
                }



                //show_date.phpからstackリストの中身をjsに渡す.
                var stack_from_php = JSON.parse('<?php echo $stack_from_php; ?>');
                var stack_start_from_php = JSON.parse('<?php echo $stack_start_from_php; ?>');
                var stack_title_from_php = JSON.parse('<?php echo $stack_title_from_php; ?>');
                // console.log(stack_from_php);

                var array_count = stack_from_php.length;  //stackの数.*日にちの数.
                // console.log(array_count); 


                for (var i = 0; i < array_count; i++) { //for構文かいし. //9
                    var stack = stack_from_php[i];//777821187
                    var stack_start = stack_start_from_php[i];
                    var stack_title = stack_title_from_php[i];
                    // console.log(stack);
                    // console.log(stack_start);
                    for (var l = 9; l < 24; l++) { //11
                        if (stack_start == l) {
                            document.getElementById(alpha[stack - 1] + '_' + l).innerHTML = '<div class="container"><canvas class="canvas" style="background-color:red;"></canvas><div class="title">' + stack_title + '</div></div>';  //_10のところをあとで治す.
                        }
                    }
                }


                //1_9をclick後、保存情報テキストフィールド展開.

                var yotei = "?php echo $list[0] ?>";
                var i = 9;

                $('.td').on('click', function () { //クリックしたidを取得. idをlocalstorageに格納.
                    var id = 0;
                    id = $(this).attr("id");
                    var array = [];
                    var obj = {
                        'id': id,
                    };
                    array.push(obj);

                    var setjson = JSON.stringify(obj);
                    localStorage.setItem('id', setjson);

                    localStorage.getItem('id');
                    var getjson = localStorage.getItem('id');
                    var obj = JSON.parse(getjson);
                    id = obj['id'];//localstrageに保存しているもの.




                    for (var m = 1; m < 16; m++) {
                        var id_alpha = alpha[m - 1];
                        reg = new RegExp(id_alpha);
                        if (id.match(reg)) {
                            var date_a = m;
                        }
                    }

                    for (var m = 0; m < 16; m++) {
                        var id_alpha = alpha[m];
                        reg = new RegExp(id_alpha);
                        if (id.match(reg)) {  //localstrageにsetしたid（クリックされた）とreg(abc...)がmatchされるか.
                            var row = m + 1;
                            break;
                        }
                    }

                    for (var i = 9; i < 23; i++) { //開始時間をstart_hに取得.
                        reg = new RegExp(i);//正規オブジェクトを使うと、正規表現のmatchにおいて、変数が使える. .match(変数).
                        if (id.match(reg)) { //localstrageの問題がありそう.早めにどっかでclearしなければ.
                            var start_h = i;
                        }
                    }

                    var finish_h = start_h + 1;


                    var tObj = document.getElementById("table");
                    var rows = tObj.rows.length; // 行数取得


                    for (var m = 0; m < 16; m++) {
                        var id_alpha = alpha[m];
                        reg = new RegExp(id_alpha);
                        if (id.match(reg)) {  //localstrageにsetしたid（クリックされた）とreg(abc...)がmatchされるか.
                            var row = m + 1;
                            break;
                        }
                    }


                    for (var m = 9; m < 24; m++) {
                        reg = new RegExp(m);
                        if (id.match(reg)) {
                            var cell = m - 7;
                            break;
                        }
                    }


                    var content = tObj.rows[row].cells[cell].innerHTML;
                    alert(content);
                    if (content == '') {
                        document.getElementById('reserve_click').innerHTML = '<form id="loginForm" name="loginForm" method="POST" action=""> '
                            + '<div id="reserve_info">'
                            + '<input type="text" name="year" id="year" maxlength="5" value=' +<? php echo $ydate;?> +'>年'
                                + '<input type="text" name="month" id="month" maxlength="5" value=' +<? php echo date("m");?> +'>月' //月の部分は、このページに表示されているもの.
                                    + '<input type="text" name="date" id="date" maxlength="5" value=' + date_a + '>日 曜日'
                                    + '<br>'
                                    + 'タイトル<input type="text" name="title" id="title" maxlength="5" value="">'
                                    + '<br>'
                                    + '<input type="text" name="start_h" id="start_h" maxlength="5" value=' + start_h + '>時'
                                    + '<input type="text" name="start_m" id="start_m" maxlength="5" value="00">分〜'
                                    + '<input type="text" name="finish_h" id="finish_h" maxlength="5" value=' + finish_h + '>時'
                                    + '<input type="text" name="finish_m" id="finish_m" maxlength="5" value="00">分まで'
                                    + '<br>'
                                    + '<p>場所</p>'
                                    + '<input type="text" name="place" id="place" maxlength="5">'
                                    + '<input type="submit" id="sub" name="sub" value="保存"></div></form>';
                    } else {
                        document.getElementById('reserve_click').innerHTML = '<form id="loginForm" name="loginForm" method="POST" action=""> '
                            + '<input type="hidden" name="year" value=' +<? php echo $ydate;?> +'>'
                                + '<input type="hidden" name="month" id="month" maxlength="5" value=' +<? php echo date("m");?> +'>'
                                    + '<input type="hidden" name="date" id="date" maxlength="5" value=' + date_a + '>'
                                    + '<input type="hidden" name="start_h" id="start_h" maxlength="5" value=' + start_h + '>'
                                    + '<input type="hidden" name="finish_h" id="finish_h" maxlength="5" value=' + finish_h + '>'
                                    + '<input type="submit" id="del" name="del" value="削除"></div></form>';
                    }
                });
            </script>
            <?php
            require_once('pdo.php');
            require_once('show_data.php');
            ?>
        </body>

</html>