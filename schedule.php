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
    <div>
        <h2 id="title">CNU CINEMA</h2></a>
        <div class="div1"></div>
        <div class="div2" id="search">
            <form action="search.php" method="get" name="search" onsubmit="return blankSearch();">
                <input type="text" id="search" name="movie_title">
                <input type="submit" value="검색">
            </form>
        </div>
        <div class="div3" id="signin">
            <button onclick="location.href='signin.html'">로그인</button>
            <button onclick="location.href='signup.php'">회원가입</button>
        </div>
    </div><br><br>
    <div>
        <hr>
    </div>
    <ul>
        <li class=""><a href="schedule.php">예매</a></li>
        <li class=""><a href="#">영화관</a></li>
    </ul>
    <div class="tname">
        <ul>
            <li class="t" id="t1box" onclick="show('t1movie')">t1</li>
            <li class="t" id="t2box" onclick="show('t2movie')">t2</li>
            <li class="t" id="t3box" onclick="show('t2movie')">t3</li>
            <li class="t" id="t4box" onclick="show('t2movie')">t4</li>
            <li class="t" id="t5box" onclick="show('t2movie')">t5</li>
        </ul>
    </div>
    <div class="movie" id="t1movie">
        <ul>
            <?php
                $results = $db->query("SELECT title FROM movie ORDER BY title;");
                foreach($results as $row){
                    $title = $row["title"];
                    echo "<li class='info' onclick='showSchedule(\"$title\")'>$title</li>";

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
                    echo "<li class='info' onclick='showSchedule(\"$title\")'>$title</li>";
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
                    echo "<li class='info' onclick='showSchedule(\"$title\")'>$title</li>";
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
                    echo "<li class='info' onclick='showSchedule(\"$title\")'>$title</li>";
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
                    echo "<li class='info' onclick='showSchedule(\"$title\")'>$title</li>";
                }
            ?>
        </ul>
    </div>
    <div class="schedule" id="t1">
        <?php
            $results = $db->query("SELECT title FROM movie ORDER BY title;");
            foreach($results as $title){
                echo "<ul class='movie_sche'>";
                $t4_sche = getTheaterScheduleR($db, "t1", $title["title"]);
                foreach($t4_sche as $row){
                    $t = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<li class='sche' id='$t'>$t, $sche, $seats</li>";
                }
                echo "</ul>";
            }
        ?>
    </div>
    <div class="schedule" id="t2">
        <?php
            $results = $db->query("SELECT title FROM movie ORDER BY title;");
            foreach($results as $title){
                echo "<ul class='movie_sche'>";
                $t4_sche = getTheaterScheduleR($db, "t2", $title["title"]);
                foreach($t4_sche as $row){
                    $t = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<li class='sche' id='$t'>$t, $sche, $seats</li>";
                }
                echo "</ul>";
            }
        ?>
    </div>
    <div class="schedule" id="t3">
        <?php
            $results = $db->query("SELECT title FROM movie ORDER BY title;");
            foreach($results as $title){
                echo "<ul class='movie_sche'>";
                $t4_sche = getTheaterScheduleR($db, "t3", $title["title"]);
                foreach($t4_sche as $row){
                    $t = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<li class='sche' id='$t'>$t, $sche, $seats</li>";
                }
                echo "</ul>";
            }
        ?>
    </div>
    <div class="schedule" id="t4">
        <?php
            $results = $db->query("SELECT title FROM movie ORDER BY title;");
            foreach($results as $title){
                echo "<ul class='movie_sche'>";
                $t4_sche = getTheaterScheduleR($db, "t4", $title["title"]);
                foreach($t4_sche as $row){
                    $t = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<li class='sche' id='$t'>$t, $sche, $seats</li>";
                }
                echo "</ul>";
            }
        ?>
    </div>
    <div class="schedule" id="t5">
        <?php
            $results = $db->query("SELECT title FROM movie ORDER BY title;");
            foreach($results as $title){
                echo "<ul class='movie_sche'>";
                $t4_sche = getTheaterScheduleR($db, "t5", $title["title"]);
                foreach($t4_sche as $row){
                    $t = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<li class='sche' id='$t'>$t, $sche, $seats</li>";
                }
                echo "</ul>";
            }
        ?>
    </div>
    <div>
        <ul>
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
        </ul>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>