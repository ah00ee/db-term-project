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
        <h1 id="title">CNU CINEMA</h2></a>
        <div class="div1"></div>
        <div class="div2" id="search">
            <form action="search.php" method="get" name="search" onsubmit="return blankSearch();">
                영화제목<input type="text" id="search" name="movie_title">
                관람일<input type="text" name="s_date" placeholder="YYYY-MM-DD">
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
    <div>
        <img src=<?php echo "covers/".str_replace(" ", "_", $t).".jpeg" ?> width="200">
        <p>
            <?php
                $arr = getMovieDetail($db, $t);
                $open_d = $arr[0];
                $close_d = $arr[1];
                if(($open_d[0]["open_day"]<=date("2022-05-05")) and ($close_d[0]["lastdate"]<=date("2022-06-03"))){
                    echo "<p id='running'>상영중| $t</p>";
                }
                else if($close_d[0]["lastdate"]>date("2022-06-03")){
                    echo "<p id='running'>상영종료| $t</p>";
                }
                else{
                    echo "<p id='running'>상영예정| $t</p>";
                }
            ?>
        </p>
    </div>
    <script type="text/javascript" src="js/main.js?after"></script>
</body>
</html>