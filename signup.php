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
    <div>
        <h2 id="title">CNU CINEMA</h2></a>
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
    <div class="signup">
        <form action="signinAfter.php" method="post" name="signup" onsubmit="return blankSignUp();">
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