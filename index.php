<?php
    include ('conn.php');
    if(isset($_SESSION["DATE"])){
        $today = $_SESSION["DATE"];
    }
    else{
        // 텀프 데모에 한해 오늘 날짜를 '2022-05-05'로 지정.
        $today = '2022-05-05';
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
            // 회원 로그인 시
            if($conn&&!$admin){
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
            // 관리자 로그인 시
            else if($conn&&$admin){
                echo "관리자 님 | <button onclick='location.href=\"manage.php\"'>관리</button>
                            <button onclick='location.href=\"signout.php\"'>로그아웃</button></div>";
        ?>
        <?php
            }
            // 로그인 전
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
    <?php
        if($conn&&!$admin){
    ?>
            <ul>
                <li class="bar"><a href="schedule.php?date=<?php echo $today;?>">예매하기</a>
            </ul><br><br>
    <?php
        }
    ?>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>