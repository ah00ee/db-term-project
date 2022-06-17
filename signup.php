<?php 
    include('conn.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/index.css?after">
    <title>CNU CINEMA LOGIN</title>
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
        <div class="div3"></div>
    </div><br><br>
    <div>
        <hr>
    </div>
    <div class="signup">
        <form action="signupAfter.php" method="post" name="signup" onsubmit="return blankSignUp();">
            <p><input type="text" name="name" placeholder="NAME"></p>
            <p><input type="text" name="bday" placeholder="Date of birth(YYYY-MM-DD)"></p>
            <p><input type="text" name="email" placeholder="EMAIL"></p>
            <p><input type="text" name="pwd" placeholder="PASSWORD"></p>
            <p><input type="text" name="sex" placeholder="SEX"></p>
            <input type="submit" value="회원가입">
        </form>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>