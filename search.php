<!--상단의 검색 버튼을 누르면 나타나는 페이지-->
<!--
    '영화제목'에 해당하는 영화의 포스터와
        상영중 -> 누적관객수, 예매자수
        상영예정 -> 예매자수
        상영종료 -> 누적관객수
    를 출력하여 같이 나타냄.
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
            if($_GET['movie_title']!=""){    // 영화 제목 검색
                $t = $_GET["movie_title"];
                // 상영 스케줄에 따른 시작일과 종료일 구하기
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
            }
            else if($_GET["s_date"]!=""){    // 날짜만 검색
                $date = $_GET["s_date"];
                $q = $db->query("SELECT sdatetime FROM schedule WHERE DATE(sdatetime)=DATE('$date')");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
        
                $q = $db->query("SELECT movie.title FROM schedule, movie WHERE DATE(sdatetime)=DATE('$date') AND schedule.mid=movie.mid");
                $movies = $q->fetchAll(PDO::FETCH_ASSOC);
        
                foreach($movies as $rows){
                    $t = $rows["title"];
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
                    $cnt = $results[0]["COUNT(*)"];?>
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
                }
            }
        ?>
    </div>
    <script type="text/javascript" src="js/main.js?after"></script>
</body>
</html>