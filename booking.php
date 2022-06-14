<?php
    if(isset($_SESSION["ID"])){
        #$session = TRUE;
        echo "로그인되어있습니다.";
        session_destroy();
    }
    else{
        echo "로그인이 필요합니다.";
    }
    include ('conn.php');
    $theater = $_GET["theater"];
    $sche = $_GET["sche"];
    $t = $_GET["title"];
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
    <div>
        <li class="bar"><a href="schedule.php">예매하기</a>
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
            $q = $db->query("SELECT seats FROM theater where tname='$theater';");
            $results = $q->fetchAll(PDO::FETCH_ASSOC);
            echo "<table border='1' class='bookingT'>";
            for($i=0; $i<$results[0]["seats"]/10; $i++){
                echo "<tr>";
                for($j=0; $j<10; $j++){
                    $n = $i*10+$j+1;
                    echo "<td width='30' class='td_' onclick='clickEvent(event)'>$n</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        ?>
        <br>
    </div>
    <div class="btm">
        <div id="cnt">
            선택 좌석 수: 0
        </div>
        <div class="bookBtn">
            <a href="bookingAfter.php">예매</a>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>