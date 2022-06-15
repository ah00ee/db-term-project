<?php
    include ('conn.php');
    $t = $_GET['movie_title'];
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
            <form action="search.php" method="get" name="search" onsubmit="return blankSearch();">
                영화제목<input type="text" id="search" name="movie_title">
                관람일<input type="text" name="s_date" placeholder="YYYY-MM-DD">
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
    <div>
        <img src=<?php echo "covers/".str_replace(" ", "_", $t).".jpeg" ?> width="200">
        <p>
            <?php
                $arr = getMovieDetail($db, $t);
                $open_d = $arr[0];
                $close_d = $arr[1];
                $q = $db->query("SELECT movie.title, movie.mid, MIN(DATE(schedule.sdatetime)) as min, MAX(DATE(schedule.sdatetime)) as max FROM schedule, movie WHERE movie.mid=schedule.mid AND movie.title='$t' GROUP BY schedule.mid ORDER BY schedule.mid;");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                $mid = $results[0]["mid"];
                $minD = $results[0]["min"];
                $maxD = $results[0]["max"];

                $q = $db->query("SELECT COUNT(*), SUM(seats) FROM ticketing WHERE sid IN (SELECT s.sid FROM schedule s WHERE s.mid='$mid');");
                $results = $q->fetchAll(PDO::FETCH_ASSOC);
                $max = $results[0]["SUM(seats)"];
                if($max == null){
                    $max = 0;
                }
                $cnt = $results[0]["COUNT(*)"];

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
    </div>
    <script type="text/javascript" src="js/main.js?after"></script>
</body>
</html>