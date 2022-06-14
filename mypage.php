<?php
    include('conn.php');
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
        <?php
            if($conn){
                $email = $_SESSION["ID"];
                $pw = $_SESSION["PWD"];
                $q=$db->query("SELECT name FROM customer WHERE email='$email' and password='$pw';");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                $name = $results[0]["name"];
                echo "<div>$name 님 | <button onclick='location.href=\"mypage.php\"'>마이페이지</button></div>";
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
    <div class="lists">
        <div class="top">
            <ul>
                <li class="myList book clicked" id="rList" onclick="check(event)">예매내역</li>
                <li class="myList cancel" id="cList"  onclick="check(event)">취소내역</li>
            </ul>
        </div>
        <div class="list-content1 book content">
            <?php
            $email = $_SESSION["ID"];
                $q=$db->query("SELECT * FROM ticketing WHERE cid=(SELECT cid FROM customer WHERE email='$email');");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                echo "<table border='1' class='bookingL book content'>
                        <tr>
                            <td class='td__1'>예매번호</td>
                            <td class='td__2'>영화제목</td>
                            <td class='td__3'>예매날짜</td>
                            <td class='td__4'>좌석 수</td>
                            <td class='td__5'>티켓상태</td>
                        </tr>";
                foreach($results as $row){
                    echo "<tr>";
                    $id = $row["id"];
                    $rc_date = $row["rc_date"];
                    $seats = $row["seats"];
                    $status = $row["status"];
                    $sid = $row["sid"];
                    $tmp=$db->query("SELECT title FROM movie WHERE mid=(SELECT mid FROM schedule WHERE sid=$sid);");
                    $r = $tmp->fetchAll(PDO::FETCH_ASSOC);
                    $title = $r[0]["title"];
                    echo "<td class='td__1'>$id</td><td class='td__2'>$title</td><td class='td__3'>$rc_date</td><td class='td__4'>$seats</td><td class='td__5'>$status</td>";
                }
            ?>
        </div>
        <div class="list-content2 cancel content">
            <?php
            $email = $_SESSION["ID"];
                $q=$db->query("SELECT * FROM ticketing WHERE cid=(SELECT cid FROM customer WHERE email='$email') and status='C';");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                echo "<table border='1' class='bookingL2 cancel content'>
                        <tr>
                            <td class='td__1'>예매번호</td>
                            <td class='td__2'>영화제목</td>
                            <td class='td__3'>예매날짜</td>
                            <td class='td__4'>좌석 수</td>
                        </tr>";
                foreach($results as $row){
                    echo "<tr>";
                    $id = $row["id"];
                    $rc_date = $row["rc_date"];
                    $seats = $row["seats"];
                    $status = $row["status"];
                    $sid = $row["sid"];
                    $tmp=$db->query("SELECT title FROM movie WHERE mid=(SELECT mid FROM schedule WHERE sid=$sid);");
                    $r = $tmp->fetchAll(PDO::FETCH_ASSOC);
                    $title = $r[0]["title"];
                    echo "<td class='td__1'>$id</td><td class='td__2'>$title</td><td class='td__3'>$rc_date</td><td class='td__4'>$seats</td><td class='td__5'>$status</td>";
                }
            ?>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>