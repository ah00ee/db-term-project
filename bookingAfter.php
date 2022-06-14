<?php
    include ('conn.php');

    $to = $_SESSION["ID"];
    $subject = "[CNU THEATER] 예매 내역입니다.";
    $content = "예매 정보.";
    $headers = "From: nay0901@naver.com\r\n";
    mail($to, $subject, $content, $headers);
?>