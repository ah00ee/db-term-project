<?php
    include ('conn.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/index.css?after">
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
            <button onclick="">회원가입</button>
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
            <li class="t">t1</li>
            <li class="t">t2</li>
            <li class="t">t3</li>
            <li class="t">t4</li>
            <li class="t">t5</li>
        </ul>
    </div>
    <div class="schedule">
        <ul>
            <?php
                $t1_sche = getTheaterSchedule($db, "t1");
                foreach($t1_sche as $row){
                    $open = $row["open_day"];
                    $title = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<p class='info'>$open, $title, $sche, $seats</p>";
                }
            ?>
        </ul>
    </div>
    <div class="schedule">
        <ul>
            <?php
                $t2_sche = getTheaterSchedule($db, "t2");
                foreach($t2_sche as $row){
                    $open = $row["open_day"];
                    $title = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<p class='info'>$open, $title, $sche, $seats</p>";
                }
            ?>
        </ul>
    </div>
    <div class="schedule">
        <ul>
            <?php
                $t3_sche = getTheaterSchedule($db, "t3");
                foreach($t3_sche as $row){
                    $open = $row["open_day"];
                    $title = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<p class='info'>$open, $title, $sche, $seats</p>";
                }
            ?>
        </ul>
    </div>
    <div class="schedule">
        <ul>
            <?php
                $t4_sche = getTheaterSchedule($db, "t4");
                foreach($t4_sche as $row){
                    $open = $row["open_day"];
                    $title = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<p class='info'>$open, $title, $sche, $seats</p>";
                }
            ?>
        </ul>
    </div>
    <div class="schedule">
        <ul>
            <?php
                $t5_sche = getTheaterSchedule($db, "t5");
                foreach($t5_sche as $row){
                    $open = $row["open_day"];
                    $title = $row["title"];
                    $sche = $row["sdatetime"];
                    $seats = $row["seats"];
                    echo "<p class='info'>$open, $title, $sche, $seats</p>";
                }
            ?>
        </ul>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>