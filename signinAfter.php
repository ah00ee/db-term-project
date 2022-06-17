<?php 
    include('conn.php');
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    $_SESSION['ID'] = $email;
    $_SESSION['PWD'] = $pwd;
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
        <div class="div3"></div>
    </div><br><br>
    <div>
        <hr>
    </div>
        <div id="signin">
            <?php
                $results = $db->query("SELECT * FROM Customer;");
                foreach ($results as $row) {
                    if ($email == $row["email"]) {
                        $name = getUserName($db, $email, $pwd);
                        echo "<p>$name 님 환영합니다.</p>";
                        break;
                    }
                }
            ?>
        </div>
    </div><br><br>
    <div>
        <hr>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>