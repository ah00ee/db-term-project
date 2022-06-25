<!--
    마이페이지에서 예매내역과 티켓 취소내역을 볼 수 있음 (<table>로 작성)
    예매 내역에서 취소 버튼을 누르면 취소내역에 추가되고 
    해당 예매 내역이 사라짐
-->
<?php
    include('conn.php');

    // '취소하기' 버튼 클릭 시,
    // 예매 내역 취소 진행. => update table set status='C' where id=id;
    if(array_key_exists('id', $_GET)){
        $bookId = $_GET["id"];
        $q = $db->exec("UPDATE ticketing SET status='C' WHERE id=$bookId;");
        echo "<script>location.href='http://localhost/mypage.php'</script>";
    }
    $today = $_SESSION["DATE"];
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
    <!--헤더: 로그인 후에는 마이페이지/ 로그인 전에는 회원가입 및 로그인 버튼을 나타냄-->
    <div class="header">
        <h1 id="title"><a href="/index.php">CNU CINEMA</a></h1>
        <div class="div1"></div>
        <div class="div2" id="search">
            <form action="search.php" method="get" id="formform" name="search" onsubmit="return blankSearch();">
                <div id="in">
                    <li>영화제목 <input type="text" id="search" name="movie_title"></li>
                    <li>관람일 <input type="date" name="s_date"></li>
                </div>
                <div id="s">
                    <input type="submit" value="검색">
                </div>
            </form>
        </div>
        <?php
            if($conn){
                $email = $_SESSION["ID"];
                $pw = $_SESSION["PWD"];
                $q=$db->query("SELECT name FROM customer WHERE email='$email' and password='$pw';");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                $name = $results[0]["name"];
                echo "<div>$name 님 | <button onclick='location.href=\"mypage.php\"'>마이페이지</button>
                                    <button onclick='location.href=\"signout.php\"'>로그아웃</button></div>";
        ?>    
        <?php
            }
            else if($conn&&$admin){
                echo "관리자 님 | <button onclick='location.href=\"manage.php\"'>관리</button>
                            <button onclick='location.href=\"signout.php\"'>로그아웃</button></div>";
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
                <li class="myList book clicked" id="rList" onclick="check(event)">예매 내역</li>
                <li class="myList watch" id="wList" onclick="check(event)">지난 관람 내역</li>
                <li class="myList cancel" id="cList"  onclick="check(event)">취소 내역</li>
            </ul>
        </div>
        <div class="list-content1 content">
            <?php
                // 예매 내역 칸
                $email = $_SESSION["ID"];
                $q=$db->query("SELECT * FROM ticketing WHERE cid=(SELECT cid FROM customer WHERE email='$email') AND status='R' ORDER BY rc_date DESC;");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);

                if($results == null){
                    echo "<h2 class='bookingL book content'>예매 내역이 없습니다.</h2>";
                }
                else{
                    echo "<table border='1' class='bookingL book content'>
                            <tr>
                                <td class='td__1'>예매번호</td>
                                <td class='td__2'>영화제목</td>
                                <td class='td__3'>상영관</td>
                                <td class='td__4'>예매날짜</td>
                                <td class='td__5'>좌석 수</td>
                                <td class='td__6'>취소</td>
                            </tr>";
                    foreach($results as $row){
                        echo "<tr>";
                        $id = $row["id"];
                        $rc_date = $row["rc_date"];
                        $seats = $row["seats"];
                        $status = $row["status"];
                        $sid = $row["sid"];
                        $tmp=$db->query("SELECT m.title, s.tname FROM movie m, schedule s WHERE m.mid=s.mid AND s.sid=$sid;");
                        $r = $tmp->fetchAll(PDO::FETCH_ASSOC);
                        $title = $r[0]["title"];
                        $tname = $r[0]["tname"];
                        $cancelId = 0;
                        echo "<td class='td__1'>$id</td>
                            <td class='td__2'>$title</td>
                            <td class='td__3'>$tname</td>
                            <td class='td__4'>$rc_date</td>
                            <td class='td__5'>$seats</td>
                            <td class='td__6'><a href='mypage.php?id=$id'>취소하기</a></td>
                        </tr>";
                    }
                }

                // 지난 관람 내역 칸
                $email = $_SESSION["ID"];
                $q=$db->query("SELECT * FROM ticketing WHERE cid=(SELECT cid FROM customer WHERE email='$email') AND status='W' ORDER BY rc_date DESC;");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);

                if($results == null){
                    echo "<h2 class='bookingL2 watch content'>지난 관람 내역이 없습니다.</h2>";
                }
                else{
                    echo "<table border='1' class='bookingL2 watch content'>
                            <tr>
                                <td class='td__1'>예매번호</td>
                                <td class='td__2'>영화제목</td>
                                <td class='td__3'>상영관</td>
                                <td class='td__4'>예매날짜</td>
                                <td class='td__5'>관람날짜</td>
                                <td class='td__6'>좌석 수</td>
                            </tr>";
                    foreach($results as $row){
                        echo "<tr>";
                        $id = $row["id"];
                        $rc_date = $row["rc_date"];
                        $seats = $row["seats"];
                        $status = $row["status"];
                        $sid = (int)$row["sid"];
                        $tmp=$db->query("SELECT m.title, s.tname, date(s.sdatetime) FROM movie m, schedule s WHERE m.mid=s.mid AND s.sid=$sid;");
                        $r = $tmp->fetchAll(PDO::FETCH_ASSOC);
                        $title = $r[0]["title"];
                        $tname = $r[0]["tname"];
                        $sdatetime = $r[0]["date(s.sdatetime)"];
                        $cancelId = 0;
                        echo "<td class='td__1'>$id</td>
                            <td class='td__2'>$title</td>
                            <td class='td__3'>$tname</td>
                            <td class='td__4'>$rc_date</td>
                            <td class='td__5'>$sdatetime</td>
                            <td class='td__6'>$seats</td>";
                    }
                }

                // 취소 내역 칸
                $q=$db->query("SELECT * FROM ticketing WHERE cid=(SELECT cid FROM customer WHERE email='$email') and status='C' ORDER BY rc_date DESC;");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                if($results == null){
                    echo "<h2 class='bookingL3 cancel content'>취소 내역이 없습니다.</h2>";
                }
                else{
                    echo "<table border='1' class='bookingL3 cancel content'>
                            <tr>
                                <td class='td__1'>예매번호</td>
                                <td class='td__2'>영화제목</td>
                                <td class='td__3'>상영관</td>
                                <td class='td__4'>예매날짜</td>
                                <td class='td__5'>좌석 수</td>
                                <td class='td__6'>취소날짜</td>
                            </tr>";
                    foreach($results as $row){
                        echo "<tr>";
                        $id = $row["id"];
                        $rc_date = $row["rc_date"];
                        $seats = $row["seats"];
                        $status = $row["status"];
                        $sid = $row["sid"];
                        $tmp=$db->query("SELECT m.title, s.tname FROM movie m, schedule s WHERE m.mid=s.mid AND s.sid=$sid;");
                        $r = $tmp->fetchAll(PDO::FETCH_ASSOC);
                        $title = $r[0]["title"];
                        $tname = $r[0]["tname"];
                        echo "<td class='td__1'>$id</td>
                            <td class='td__2'>$title</td>
                            <td class='td__3'>$tname</td>
                            <td class='td__4'>$rc_date</td>
                            <td class='td__5'>$seats</td>
                            <td class='td__6'>$today</td>
                            </tr>";
                    }
                }
            ?>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>