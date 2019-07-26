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
    ?>

    <body>

	<div id="year"><?php $ydate = date("Y"); echo $ydate?>年</div>
        <!-- この画面の年はこのydateに格納する、あとで加工必要あり. -->
    <div id="month"><?php $mdate = date("m"); echo $mdate?>月</div>
        <!-- この画面の年はこのmdateに格納する、あとで加工必要あり. -->
	<div id="content">

            <table class="table_table" id="table">

            <div id="reserve_click"></div>

            <thead id="theadID"></thead>
            <tbody id="tbodyID"></tbody>

            </table>

        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
        </script>
        <script src="https://rawgithub.com/kangax/fabric.js/master/dist/fabric.js"></script>
        <script type="text/javascript">

        var alpha = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o'];


        //table作成.
        window.onload = function(){
            var thead = document.getElementById('theadID');
            var th_item = '';
            for(var i = 9; i<23; i++){
                var th_item = th_item+'<th>'+i+':00</th>';
                }
                thead.innerHTML= '<tr><th class="date"></th><th id="day"></th>'+th_item+'<th>備考</th>';
                var tbody = document.getElementById('tbodyID');
                for(var k = 0; k<15; k++){
                        var td_item = '';
                    for(var m =9; m<24; m++){
                        var mm = parseInt(m)-8;
                        var td_item = td_item+'<td class="td" id="'+alpha[k]+'_'+m+'"></td>';
                    }
                    var kk = parseInt(k)+1;
                    var tbody_item= '<tr><th>'+kk+'</th><td></td>'+td_item+'';
                    tbody.innerHTML += tbody_item;
                }
                
        }
        


        <?php $i = 0; $_SESSION[‘i’] = $i; ?> //$iに０を入れておく.

        var array_count = <?php $stack_count = count($stack); echo $stack_count; ?>;  //stackのcount.


        for(var i = 0; i<array_count ; i++){ //for構文かいし. //9
            console.log(i);
            var stack = <?php if(count($stack)== 0){echo 0;}else{  echo $stack[$_SESSION[‘i’]];} ?>;//777821187
            var stack_start = <?php if(count($stack)== 0){echo 0;}else{  echo $stack_start[$_SESSION[‘i’]];} ?>;
            console.log(stack);
            console.log(stack_start);
            for(var l= 9; l<24; l++){ //11
                if(stack_start == l){
                    document.getElementById(alpha[stack-1]+'_'+l).innerHTML = '<p>入った！</p>';  //_10のところをあとで治す.
                }
            }
            <?php
                session_start();
                $i =$_SESSION[‘i’] ;

                $i++;

                $_SESSION[‘i’] = $i;

            ?>
	}


           //1_9をclick後、保存情報テキストフィールド展開.

            var yotei = "<?php echo $list[0] ?>";
            var i = 9;

            $('.td').on('click', function(){ //クリックしたidを取得. idをlocalstorageに格納.

                var id =0;
                id =  $(this).attr("id");
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




               for(var m = 1; m<16; m++){
                    var id_alpha = alpha[m-1];
                    reg = new RegExp(id_alpha);
                    if(id.match(reg)){
                        var date_a = m;
                    }
                }

                for(var m = 0; m<16; m++){
                    var id_alpha = alpha[m];
                    reg = new RegExp(id_alpha);
                    if(id.match(reg)){  //localstrageにsetしたid（クリックされた）とreg(abc...)がmatchされるか.
                        var row = m+1;
                        break;
                    }
                }

                for(var i = 9; i<23; i++){ //開始時間をstart_hに取得.
                reg = new RegExp(i);//正規オブジェクトを使うと、正規表現のmatchにおいて、変数が使える. .match(変数).
                    if(id.match(reg)){ //localstrageの問題がありそう.早めにどっかでclearしなければ.
                        var start_h = i;
                    }
                }

                var finish_h = start_h + 1;


                var tObj=document.getElementById("table");
                var rows = tObj.rows.length; // 行数取得


                for(var m = 0; m<16; m++){
                    var id_alpha = alpha[m];
                    reg = new RegExp(id_alpha);
                    if(id.match(reg)){  //localstrageにsetしたid（クリックされた）とreg(abc...)がmatchされるか.
                        var row = m+1;
                        break;
                    }
                }
                console.log(row);

                for(var m = 9; m<24; m++){
                    reg = new RegExp(m);
                    if(id.match(reg)){
                        var cell = m-7;
                        break;
                    }
                }
                console.log(cell);

                var content = tObj.rows[row].cells[cell].innerHTML;
                alert(content);
                if( content == '' ){
                    document.getElementById('reserve_click').innerHTML = '<form id="loginForm" name="loginForm" method="POST" action=""> '
                    + '<div id="reserve_info">'
                    +'<input type="text" name="year" id="year" maxlength="5" value='+<?php echo $ydate;?>+'>年'
                    +'<input type="text" name="month" id="month" maxlength="5" value='+<?php echo date("m");?>+'>月' //月の部分は、このページに表示されているもの.
                    +'<input type="text" name="date" id="date" maxlength="5" value='+date_a+'>日 曜日'
                    +'<br>'
                    +'タイトル<input type="text" name="title" id="title" maxlength="5" value="">'
                    +'<br>'
                    +'<input type="text" name="start_h" id="start_h" maxlength="5" value='+start_h+'>時'
                    +'<input type="text" name="start_m" id="start_m" maxlength="5" value="00">分〜'
                    +'<input type="text" name="finish_h" id="finish_h" maxlength="5" value='+finish_h+'>時'
                    +'<input type="text" name="finish_m" id="finish_m" maxlength="5" value="00">分まで'
                    +'<br>'
                    +'<p>場所</p>'
                    +'<input type="text" name="place" id="place" maxlength="5">'
                    +'<input type="submit" id="sub" name="sub" value="保存"></div></form>';
                }else {
                    document.getElementById('reserve_click').innerHTML = '<form id="loginForm" name="loginForm" method="POST" action=""> '
                    +'<input type="submit" id="del" name="del" value="削除"></div></form>';
                }



            });


            // localStorage.getItem('id');
            // var getjson = localStorage.getItem('id');
            // var obj = JSON.parse(getjson);




        </script>
        <?php
            require_once('pdo.php');
            require_once('show_data.php');
        ?>
</body>

</html>
