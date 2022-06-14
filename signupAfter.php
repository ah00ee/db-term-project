<?php 
    include('conn.php');

    $email = $_POST["email"];
    $pw = $_POST["pwd"];
    $name = $_POST["name"];
    $bday = $_POST["bday"];
    $sex = $_POST["sex"];

    $q = $db->query("SELECT COUNT(*) FROM customer;");
    $results = $q->fetchAll(PDO::FETCH_ASSOC);
    $cnt = $results[0]["COUNT(*)"];
    $q = $db->exec("INSERT INTO customer values ($cnt, '$name', '$pw', '$email', '$bday', '$sex');");
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/index.css">
    <title>CNU CINEMA</title>
</head>
<body>
    <div class="header">
        <h1 id="title"><a href="/index.php">CNU CINEMA</a></h1>
        <div class="div1"></div>
        <div class="div2" id="search">
            <form action="search.php" method="get" name="search" onsubmit="return blankSearch();">
                영화제목 <input type="text" id="search" name="movie_title">
                관람일 <input type="date" name="date">
                <input type="submit" value="검색">
            </form>
        </div>
    </div><br><br>
    <div>
        <hr>
    </div>
    <div id="signup">
        <p>회원가입이 완료되었습니다!<br> 다시 로그인 해주시기 바랍니다.</p>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>