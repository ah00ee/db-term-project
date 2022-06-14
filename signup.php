<?php 
    include('conn.php');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/signin.css?after">
    <title>CNU CINEMA LOGIN</title>
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