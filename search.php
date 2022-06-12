<?php
    include ('conn.php');
    $t = str_replace(" ", "_", $_GET['movie_title']);
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
<div>
        <h2 id="title">CNU CINEMA</h2></a>
        <div class="div1"></div>
        <div class="div2" id="search">
            <form action="search.php" method="get" name="search" onsubmit="return blankSearch();">
                <input type="text" id="search" name="movie_title">
                <input type="submit" value="검색">
            </form>
        </div>
        <div class="div3" id="signin">
            <button onclick="location.href='signin.html'">로그인</button>
            
        </div>
    </div><br><br>
    <div>
        <hr>
    </div>
    <div>
        <img src=<?php echo "covers/".$t.".jpeg" ?> width="200">
        <p><?php echo $t ?></p>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>