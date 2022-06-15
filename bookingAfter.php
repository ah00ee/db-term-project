<!--예매 완료 후 나타나는 페이지-->
<!--
    예매 완료 후, 사용자에게 예매 완료 메일을 발송(php의 mail()사용.)
    예매 완료 메일 내용은 다음과 같음.

    //
    [<예매자> 님 예매 정보]
    
    예매 날짜: -
    예매 영화: -
    상영관: -
    상영 날짜 및 시간: -
    예매 좌석 수: -
    
    즐거운 관람되세요.
    //
-->
<?php
    include ('conn.php');

    $to = $_SESSION["ID"];
    
    $q = $db->query("SELECT cid, name FROM customer WHERE email='$to';");
    $results = $q->fetchAll(PDO::FETCH_ASSOC);
    $cid = $results[0]["cid"];
    $name = $results[0]["name"];

    $cnt = $_POST["number"];
    $sid = $_GET["sid"];
    $q=$db->exec("INSERT INTO ticketing(rc_date, seats, status, cid, sid) values ('2022-05-05', $cnt, 'R', $cid, $sid);");
    
    $q=$db->query("SELECT mid, sdatetime, tname FROM schedule WHERE sid=$sid;");
    $results = $q->fetchAll(PDO::FETCH_ASSOC);
    $dt = $results[0]["sdatetime"];
    $t = $results[0]["tname"];
    $mid = $results[0]["mid"];

    $q=$db->query("SELECT title FROM movie WHERE mid='$mid';");
    $results = $q->fetchAll(PDO::FETCH_ASSOC);
    $title = $results[0]["title"];

    $subject = "[CNU THEATER] 예매 내역입니다.";
    $content = "[$name 님 예매 정보]\n\n예매 날짜: 2022-05-05\n예매 영화: $title\n상영관: $t\n상영 날짜 및 시간: $dt\n예매 좌석 수: $cnt\n\n 즐거운 관람되세요.";
    $headers = "From: nay0901@naver.com\r\n";
    mail($to, $subject, $content, $headers);
?>
<?php
    include ('conn.php');
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
                관람일 <input type="date" name="s_date">
                <input type="submit" value="검색">
            </form>
        </div>
        <?php
            if($conn){
                $email = $_SESSION["ID"];
                $pw = $_SESSION["PWD"];
                $q=$db->query("SELECT name FROM customer WHERE email='$email' and password='$pw';");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                $name = $results[0]["name"];
                echo "<div>$name 님 | <button onclick='location.href=\"mypage.php\"'>마이페이지</button>";
        ?>    
            
        <?php
            }
            else{
        ?>
        <div class="div3" id="signin">
            <button onclick="location.href='signin.php'">로그인</button>
            <button onclick="location.href='signup.php'">회원가입</button>
        </div>
        <?php
            }
        ?>
    </div><br><br>
    <div>
        <hr>
    </div>
    <h3>예매 완료</h3>
    
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>