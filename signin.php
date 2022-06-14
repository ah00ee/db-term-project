<?php
    include ('conn.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/signin.css?after">
    <title>CNU CINEMA LOGIN</title>
</head>
<body>
    <div>
        <h1 id="title"><a href="/index.php">CNU CINEMA</a></h1>
        <div class="div1"></div>
        <div class="div2" id="search">
            <form action="search.php" method="get" name="search" onsubmit="return blankSearch();">
                <input type="text" id="search" name="movie_title">
                <input type="submit" value="검색">
            </form>
        </div>
        <div class="div3"></div>
    </div><br><br>
    <div>
        <hr>
    </div>
    <div class="signin">
        <?php
            if($conn){
        ?>    
        <h2>로그인되어있습니다.</h2>
        <?php
            }
            else{
        ?>
        <form action="signinAfter.php" method="post">
            <p><input type="text" name="email" placeholder="EMAIL"></p>
            <p><input type="text" name="pwd" placeholder="PASSWORD"></p>
            <input type="submit" value="로그인">
        </form>
        <?php
            }
        ?>
    </div>
    <script type="text/javascript" src="js/main.js?after"></script>
</body>
</html>