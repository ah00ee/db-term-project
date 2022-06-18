<!--'예매하기' 버튼을 누르면 나오는 페이지-->
<!--
    각 날짜와 상영관에 해당하는 상영 스케줄을 출력함.
    날짜와 상영관은 선택할 수 클릭하여 변경할 수 있음.
-->
<?php
    include ('conn.php');
    if(isset($_SESSION["DATE"])){
        $today = $_SESSION["DATE"];
    }
    else{
        $today = '2022-05-05';
    }
    if(isset($_GET["date"])){
        $set_today = $_GET["date"];
    }
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
    <ul>
        <li class="bar"><a href="schedule.php">예매하기</a>
    </ul><br><br>
    <div>
        <ul class="date_select">
            <?php
                // 현재 날짜부터 14일간의 스케줄을 확인할 수 있음.
                for($i=0; $i<14; $i++){
                    $set_date = strval(date("Y-m-d", strtotime("$today+$i days")));
                    $set = strval(date("j", strtotime($set_date)));
                    echo "<li class='date' id=$set_date onclick='dateChange(event)'><a href='schedule.php?date=$set_date'>".$set."</a></li>";
                }
            ?>
        </ul>
    </div>
    <br><br>
    <div class="tname">
        <ul>
            <li class="t" id="t1box" onclick="show('t1', event)">t1</li>
            <li class="t" id="t2box" onclick="show('t2', event)">t2</li>
            <li class="t" id="t3box" onclick="show('t3', event)">t3</li>
            <li class="t" id="t4box" onclick="show('t4', event)">t4</li>
            <li class="t" id="t5box" onclick="show('t5', event)">t5</li>
        </ul>
    </div>
    <div class="sche_box">
        <div class="schedule" id="t1">
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $title){
                    $t = $title["title"];
                    echo "<h3>$t</h3>";
                    echo "<ul class='t1movie_sche$t'>";
                    $t1_sche = getTheaterScheduleR($db, "t1", $t, $set_today);
                    foreach($t1_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, 총 $seats 좌석</a></li>";
                    }
                    echo "</ul>";
                }
            ?>
        </div>
        <div class="schedule" id="t2">
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $title){
                    $t = $title["title"];
                    echo "<h3>$t</h3>";
                    echo "<ul class='t2movie_sche$t'>";
                    $t2_sche = getTheaterScheduleR($db, "t2", $t, $set_today);
                    foreach($t2_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, 총 $seats 좌석</a></li>";
                    }
                    echo "</ul>";
                }
            ?>
        </div>
        <div class="schedule" id="t3">
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $title){
                    $t = $title["title"];
                    echo "<h3>$t</h3>";
                    echo "<ul class='t3movie_sche$t'>";
                    $t3_sche = getTheaterScheduleR($db, "t3", $t, $set_today);
                    foreach($t3_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, 총 $seats 좌석</a></li>";
                    }
                    echo "</ul>";
                }
            ?>
        </div>
        <div class="schedule" id="t4">
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $title){
                    $t = $title["title"];
                    echo "<h3>$t</h3>";
                    echo "<ul class='t4movie_sche$t'>";
                    $t4_sche = getTheaterScheduleR($db, "t4", $t, $set_today);
                    foreach($t4_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, 총 $seats 좌석</a></li>";
                    }
                    echo "</ul>";
                }
            ?>
        </div>
        <div class="schedule" id="t5">
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $title){
                    $t = $title["title"];
                    echo "<h3>$t</h3>";
                    echo "<ul class='t5movie_sche$t'>";
                    $t5_sche = getTheaterScheduleR($db, "t5", $t, $set_today);
                    foreach($t5_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, 총 $seats 좌석</a></li>";
                    }
                    echo "</ul>";
                }
            ?>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js?after"></script>
</body>
</html>