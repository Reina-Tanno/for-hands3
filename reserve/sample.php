<!DOCTYPE html>
<html>
<head>
 <title>sample</title>
    <meta http-equiv="content-type" charset="utf-8">
 <link rel="stylesheet" href="style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>
    function fetchDeta(){

            let params = new URLSearchParams();
            params.set('year', document.getElementById('year').value);
            params.set('month', document.getElementById('month').value);
            params.set('date', document.getElementById('date').value);
            params.set('from_a0', document.getElementById('from_a0').value);
            params.set('from_a1', document.getElementById('from_a1').value);
            params.set('to_b0', document.getElementById('to_b0').value);
            params.set('to_b1', document.getElementById('to_b1').value);
            params.set('user_name', document.getElementById('user_name').value);

            fetch('Get_sample.php?' + params.toString())
                .then(function (response) {
                    console.log(response.headers.get('Content-Type')); //text/html; charset=UTF-8
                    console.log(response.headers.get('Date')); //Wed, 16 Jan 2019 03:08:21 GMT
                    console.log(response.status); //200
                    return response.text();
                })
                .then(function (data) {
                    document.getElementById('result').textContent = data;
                })
                .catch(function (error) {
                    document.getElementById('result').textContent = error;
                })

      }




    </script>

    </head>

        <body bgcolor="#F5DA81">


<p id="title">スケジュール登録</p>
<div id="today">
<input id="year" type="text" value="<?php echo date("Y")?>">
<input id="month" type="text">
<input id="date" type="text">

</div>
<div>
<input id="from_a0" type="text"> :
<input id="from_a1" type="textfield">
~
<input id="to_b0" type="text"> :
<input id="to_b1" type="textfield">

<input id="user_name" type="textfield"> さん

<div id="result"></div>
<div id ="info"></div>

<input id="button" onclick="fetchDeta()" type="button" value="予約" />

</div>



</body>
</html>

