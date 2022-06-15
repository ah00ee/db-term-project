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
    <ul>
        <li class="bar"><a href="schedule.php">예매하기</a>
    </ul><br><br>
    <div>
        <ul class="date_select">
            <li class="date">5</li>
            <li class="date">6</li>
            <li class="date">7</li>
            <li class="date">8</li>
            <li class="date">9</li>
            <li class="date">10</li>
            <li class="date">11</li>
            <li class="date">12</li>
            <li class="date">13</li>
            <li class="date">14</li>
            <li class="date">15</li>
            <li class="date">16</li>
            <li class="date">17</li>
            <!--
            <li class="date">18</li>
            <li class="date">19</li>
            <li class="date">20</li>
            <li class="date">21</li>
            <li class="date">22</li>
            <li class="date">23</li>
            <li class="date">24</li>
            <li class="date">25</li>
            <li class="date">26</li>
            <li class="date">27</li>
            <li class="date">28</li>
            <li class="date">29</li>
            <li class="date">30</li>
            <li class="date">31</li>
            <li class="date">1</li>
            <li class="date">2</li>
            <li class="date">3</li>
-->
        </ul>
    </div>
    <br><br>
    <div class="tname">
        <ul>
            <li class="t" id="t1box" onclick="show('t1movie')">t1</li>
            <li class="t" id="t2box" onclick="show('t2movie')">t2</li>
            <li class="t" id="t3box" onclick="show('t3movie')">t3</li>
            <li class="t" id="t4box" onclick="show('t4movie')">t4</li>
            <li class="t" id="t5box" onclick="show('t5movie')">t5</li>
        </ul>
    </div>
    <div class="movie" id="t1movie">
        <ul>
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $row){
                    $title = $row["title"];
                    echo "<li class='t1info' id='t1$title' onclick='showSchedule(\"t1\", \"$title\")'>$title</li>";

                }
            ?>
        </ul>
    </div>
    <div class="movie" id="t2movie">
        <ul>
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $row){
                    $title = $row["title"];
                    echo "<li class='t2info' id='t2$title' onclick='showSchedule(\"t2\", \"$title\")'>$title</li>";
                }
            ?>
        </ul>
    </div>
    <div class="movie" id="t3movie">
        <ul>
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $row){
                    $title = $row["title"];
                    echo "<li class='t3info' id='t3$title' onclick='showSchedule(\"t3\", \"$title\")'>$title</li>";
                }
            ?>
        </ul>
    </div>
    <div class="movie" id="t4movie">
        <ul>
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $row){
                    $title = $row["title"];
                    echo "<li class='t4info' id='t4$title' onclick='showSchedule(\"t4\", \"$title\")'>$title</li>";
                }
            ?>
        </ul>
    </div>
    <div class="movie" id="t5movie">
        <ul>
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $row){
                    $title = $row["title"];
                    echo "<li class='t5info' id='t5$title' onclick='showSchedule(\"t5\", \"$title\")'>$title</li>";
                }
            ?>
        </ul>
    </div>
    <div class="sche_box">
        <div class="schedule" id="t1">
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $title){
                    $t = $title["title"];
                    echo "<ul class='t1movie_sche$t'>";
                    $t1_sche = getTheaterScheduleR($db, "t1", $t);
                    foreach($t1_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, $seats</a></li>";
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
                    echo "<ul class='t2movie_sche$t'>";
                    $t2_sche = getTheaterScheduleR($db, "t2", $t);
                    foreach($t2_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, $seats</a></li>";
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
                    echo "<ul class='t3movie_sche$t'>";
                    $t3_sche = getTheaterScheduleR($db, "t3", $t);
                    foreach($t3_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, $seats</a></li>";
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
                    echo "<ul class='t4movie_sche$t'>";
                    $t4_sche = getTheaterScheduleR($db, "t4", $t);
                    foreach($t4_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, $seats</a></li>";
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
                    echo "<ul class='t5movie_sche$t'>";
                    $t5_sche = getTheaterScheduleR($db, "t5", $t);
                    foreach($t5_sche as $row){
                        $sche = $row["sdatetime"];
                        $seats = $row["seats"];
                        $sid = $row["sid"];
                        echo "<li class='sche$t'><a href='booking.php?theater=t2&title=$t&sche=$sche&sid=$sid'>$sche, $seats</a></li>";
                    }
                    echo "</ul>";
                }
            ?>
        </div>
    </div>
    
    <script type="text/javascript" src="js/main.js?after"></script>
</body>
</html>