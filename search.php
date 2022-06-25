<!--상단의 검색 버튼을 누르면 나타나는 페이지-->
<!--
    '영화제목'
-->
<!--
    '관람일'
-->
<!--
    '영화제목'과 '관람일' 모두 
-->
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
    <div>
        <?php
            if($_GET['movie_title']!=""&&$_GET['s_date']==""){    // 영화 제목 검색
                $t = $_GET["movie_title"];
                $q = $db->query("SELECT DISTINCT * FROM schedule, movie WHERE movie.title='$t' AND schedule.mid=movie.mid ORDER BY schedule.sid;");
                $movies = $q->fetchAll(PDO::FETCH_ASSOC);

                if($movies == null){
                    echo "<h4>해당 영화의 상영 스케줄이 없습니다.</h4>";
                }
                else{
                    // 상영 스케줄에 따른 시작일과 종료일 구하기
                    $q = $db->query("SELECT movie.title, movie.open_day, movie.mid, MIN(DATE(schedule.sdatetime)) as min, MAX(DATE(schedule.sdatetime)) as max FROM schedule, movie WHERE movie.mid=schedule.mid AND movie.title='$t' GROUP BY schedule.mid ORDER BY schedule.mid;");
                    $results = $q->fetchAll(PDO::FETCH_ASSOC);
                    $open = $results[0]["open_day"];
                    $mid = $results[0]["mid"];
                    $minD = $results[0]["min"];
                    $maxD = $results[0]["max"];
            
                    // 누적 관객 수 및 예매자 수 구하기
                    // 누적 관객 수: 티켓팅 내역에서 예매한 좌석 수를 기준으로 출력
                    // 예매자 수: 티켓팅 내역에서 해당 영화의 티켓팅 수를 출력
                    $q = $db->query("SELECT COUNT(*), SUM(seats) FROM ticketing WHERE sid IN (SELECT s.sid FROM schedule s WHERE s.mid='$mid');");
                    $results = $q->fetchAll(PDO::FETCH_ASSOC);
                    $max = $results[0]["SUM(seats)"];
                    if($max == null){
                        $max = 0;
                    }
                    $cnt = $results[0]["COUNT(*)"];
            ?>
                <img src=<?php echo "covers/".str_replace(" ", "_", $t).".jpeg" ?> width="300">
                <p>
                <?php
                    // 영화 Description
                    if($minD<='2022-05-05' && $maxD>='2022-05-05'){
                        echo "<p id='running'>상영중| $t<br>누적 관객 수| $max<br>예매자 수| $cnt</p>";
                        echo "<h3><상영 스케줄></h3>";
                    }
                    else if($maxD<'2022-05-05'){
                        echo "<p id='running'>상영종료| $t<br>누적 관객 수| $max</p>";
                        echo "<h3><상영 완료 스케줄></h3>";
                    }
                    else{
                        $left = (strtotime($open)-strtotime('2022-05-05'))/(24*60*60);
                        echo "<p id='running'>상영예정 | D-".$left." | $t<br>예매자 수| $cnt</p>";
                        echo "<h3><상영 예정 스케줄></h3>";
                    }
                ?>
                </p>
            <?php
                    for($i=1; $i<6; $i++){
                        $tname="t".strval($i);
                        $sche = getTheaterScheduleR($db, $tname, $t, "");
                        if($sche != null){
                            echo "<h4>상영관 $tname</h4>";
                        }
                        foreach($sche as $tn){
                            $sdatetime = $tn["sdatetime"];
                            $sid = $tn["sid"];
                            $left = getLeftSeats($db, $tname, $sid);
                            $seats = $left[0]-$left[1];
                            echo "<li class='sche$t'><a href='booking.php?theater=$tname&title=$t&sche=$sdatetime&sid=$sid'>$sdatetime, 총 $seats 좌석</a></li>";
                        }
                    }
                    echo "<br>";
                }
            }
            else if($_GET["s_date"]!=""&&$_GET["movie_title"]==""){    // 날짜만 검색
                $date = $_GET["s_date"];
                $q = $db->query("SELECT DISTINCT movie.title FROM schedule, movie WHERE DATE(sdatetime)=DATE('$date') AND schedule.mid=movie.mid ORDER BY movie.open_day;");
                $movies = $q->fetchAll(PDO::FETCH_ASSOC);
                if($movies == null){
                    echo "<h4>해당 날짜에 예정된 상영 스케줄이 없습니다.</h4>";
                }
                else{
                    echo "<h3>상영 스케줄</h3>";
                    echo "<h4><$date></h4><br>";
                    foreach($movies as $title){
                        // 상영 스케줄에 따른 시작일과 종료일 구하기
                        $t = $title["title"];
                        $q = $db->query("SELECT movie.title, movie.mid, MIN(DATE(schedule.sdatetime)) as min, MAX(DATE(schedule.sdatetime)) as max FROM schedule, movie WHERE movie.mid=schedule.mid AND movie.title='$t' GROUP BY schedule.mid ORDER BY schedule.mid;");
                        $results = $q->fetchAll(PDO::FETCH_ASSOC);
                        $mid = $results[0]["mid"];
                        $minD = $results[0]["min"];
                        $maxD = $results[0]["max"];
            
                        // 누적 관객 수 및 예매자 수 구하기
                        // 누적 관객 수: 티켓팅 내역에서 예매한 좌석 수를 기준으로 출력
                        // 예매자 수: 티켓팅 내역에서 해당 영화의 티켓팅 수를 출력
                        $q = $db->query("SELECT COUNT(*), SUM(seats) FROM ticketing WHERE sid IN (SELECT s.sid FROM schedule s WHERE s.mid='$mid');");
                        $results = $q->fetchAll(PDO::FETCH_ASSOC);
                        $max = $results[0]["SUM(seats)"];
                        if($max == null){
                            $max = 0;
                        }
                        $cnt = $results[0]["COUNT(*)"];
            ?>  
                    <img src=<?php echo "covers/".str_replace(" ", "_", $t).".jpeg" ?> width="200">
                    <p>
                        <?php
                        // 영화 Description                        
                        if($minD<='2022-05-05' && $maxD>='2022-05-05'){
                            echo "<p id='running'>상영중| $t<br>누적 관객 수| $max<br>예매자 수| $cnt</p>";
                        }
                        else if($maxD<'2022-05-05'){
                            echo "<p id='running'>상영종료| $t<br>누적 관객 수| $max</p>";
                        }
                        else{
                            echo "<p id='running'>상영예정| $t<br>예매자 수| $cnt</p>";
                        }
                        ?>
                    </p>
                    <?php
                        for($i=1; $i<6; $i++){
                            $tname="t".strval($i);
                            $sche = getTheaterScheduleR($db, $tname, $t, $date);
                            if($sche != null){
                                echo "<h4>상영관 $tname</h4>";
                            }
                            foreach($sche as $tn){
                                $sdatetime = $tn["sdatetime"];
                                $sid = $tn["sid"];
                                $left = getLeftSeats($db, $tname, $sid);
                                $seats = $left[0]-$left[1];
                                echo "<li class='sche$t'><a href='booking.php?theater=$tname&title=$t&sche=$sdatetime&sid=$sid'>$sdatetime, 총 $seats 좌석</a></li>";
                            }
                        }
                        echo "<br>";
                    }
                }
            }
            else{       // 영화제목과 관람일 동시 검색
                $movie = $_GET["movie_title"];
                $date = $_GET["s_date"];

                $q = $db->query("SELECT * FROM schedule, movie WHERE DATE(sdatetime)=DATE('$date') AND movie.title='$movie' AND schedule.mid=movie.mid ORDER BY schedule.sid;");
                $movies = $q->fetchAll(PDO::FETCH_ASSOC);
                if($movies == null){
                    echo "<h4>해당 날짜에 예정된 상영 스케줄이 없습니다.</h4>";
                }
                else{
                    // 상영 스케줄에 따른 시작일과 종료일 구하기
                $q = $db->query("SELECT movie.title, movie.mid, MIN(DATE(schedule.sdatetime)) as min, MAX(DATE(schedule.sdatetime)) as max FROM schedule, movie WHERE movie.mid=schedule.mid AND movie.title='$movie' GROUP BY schedule.mid ORDER BY schedule.mid;");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                $mid = $results[0]["mid"];
                $minD = $results[0]["min"];
                $maxD = $results[0]["max"];
        
                // 누적 관객 수 및 예매자 수 구하기
                // 누적 관객 수: 티켓팅 내역에서 예매한 좌석 수를 기준으로 출력
                // 예매자 수: 티켓팅 내역에서 해당 영화의 티켓팅 수를 출력
                $q = $db->query("SELECT COUNT(*), SUM(seats) FROM ticketing WHERE sid IN (SELECT s.sid FROM schedule s WHERE s.mid='$mid');");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                $max = $results[0]["SUM(seats)"];
                
                if($max == null){
                    $max = 0;
                }
                $cnt = $results[0]["COUNT(*)"];
                ?>  
                <img src=<?php echo "covers/".str_replace(" ", "_", $t).".jpeg" ?> width="200">
                <p>
                <?php
                    // 영화 Description
                    if($minD<='2022-05-05' && $maxD>='2022-05-05'){
                        echo "<p id='running'>상영중| $t<br>누적 관객 수| $max<br>예매자 수| $cnt</p>";
                    }
                    else if($maxD<'2022-05-05'){
                        echo "<p id='running'>상영종료| $t<br>누적 관객 수| $max</p>";
                    }
                    else{
                        echo "<p id='running'>상영예정| $t<br>예매자 수| $cnt</p>";
                        
                    }
                ?>
                </p>  
                <?php 
                    for($i=1; $i<6; $i++){
                        $tname="t".strval($i);
                        $sche = getTheaterScheduleR($db, $tname, $t, $date);
                        if($sche != null){
                            echo "<h4>상영관 $tname</h4>";
                        }
                        foreach($sche as $tn){
                            $sdatetime = $tn["sdatetime"];
                            $sid = $tn["sid"];
                            $left = getLeftSeats($db, $tname, $sid);
                            $seats = $left[0]-$left[1];
                            echo "<li class='sche$t'><a href='booking.php?theater=$tname&title=$t&sche=$sdatetime&sid=$sid'>$sdatetime, 총 $seats 좌석</a></li>";
                        }
                    }
                    echo "<br>";
                }
            }
            ?>          
    </div>
    <script type="text/javascript" src="js/main.js?after"></script>
</body>
</html>