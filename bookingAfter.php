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
    $content = "$name 님 예매 정보\n예매 날짜: 2022-05-05\n예매 영화: $title\n상영관: $t\n상영 날짜 및 시간: $dt\n예매 좌석 수: $cnt\n\n 즐거운 관람되세요.";
    $headers = "From: nay0901@naver.com\r\n";
    mail($to, $subject, $content, $headers);
    echo "예매 완료";
?>