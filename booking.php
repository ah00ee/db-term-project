<!--예매하기의 상영스케줄을 누르면 나타나는 페이지-->
<!--
    남은 좌석 수를 보여주고 좌석 수를 선택하여 예매할 수 있도록 함.
    이때, 선택할 수 있는 좌석 수는 1 이상 10 이하임.
-->
<?php
    include ('conn.php');
    $theater = $_GET["theater"];
    $sche = $_GET["sche"];
    $t = $_GET["title"];
    $sid = $_GET["sid"];
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
    <div>
        <li class="bar"><a href="schedule.php?date=2022-05-05">예매하기</a>
    </div><br><br>
    <div>
        <img src=<?php echo "covers/".str_replace(" ", "_", $t).".jpeg" ?> width="50">
        <p>
            <?php
                echo "$t<br>$sche";
            ?>
        </p>
    </div>
    <div>
        <?php
            // 남은 좌석 수 계산을 위함.
            // $seats-$max = (상영관의 총 좌석수)-(예매된 좌석 수)
            // (예매된 좌석 수) = 같은 sid를 가진 티켓팅 내역의 seats의 합. 이때, 취소표는 제외.
            $q = $db->query("SELECT seats FROM theater WHERE tname='$theater';");
            $results = $q->fetchAll(PDO::FETCH_ASSOC);
            $seats = $results[0]["seats"];
            $q = $db->query("SELECT SUM(seats) FROM ticketing WHERE sid=$sid AND status!='C';");
            $results = $q->fetchAll(PDO::FETCH_ASSOC);
            $max = $results[0]["SUM(seats)"];
        ?>
        <br>
    </div>
    <!--예매 칸-->
    <div class="btm">
        <form action="bookingAfter.php?sid=<?php echo "$sid"?>" name="cnt" id="cnt" method="post">
            <div class="btm1">
                <p><?php echo "남은 좌석 수: "; echo strval($seats-$max);?></p>
                <?php
                    if($seats-$max<10){
                ?>
                <p>선택 좌석 수: <input type="number" name="number" min="1" max="<?php echo $seats-$max?>"></p>
                <?php
                    }
                    else{
                ?>
                <p>선택 좌석 수: <input type="number" name="number" min="1" max="10"></p>
                <?php
                    }
                ?>
            </div>
            <div class="btm1">
                <input type="submit" id="bookingBtn" value="예매">
            </div>
        </form>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>