<?php
    include ('conn.php');
    if(isset($_SESSION["DATE"])){
        $today = $_SESSION["DATE"];
    }
    else{
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
            else if($conn&&$admin){
                echo "관리자 님 | <button onclick='location.href=\"manage.php\"'>관리</button>
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
    <!--
    <div id="rec">
        <h3>영화 관람 기록</h3>
    </div>
    <div class="lists">
        <div class="admin_top">
            <form action="" name="check">
                <input type="checkbox" name="whole">전체
                <input type="checkbox" name="r">예매
                <input type="checkbox" name="w">관람
                <input type="checkbox" name="c">취소
                <input type="submit" id="admin_s" name="admin_s" value="검색하기">
            </form>
        </div>
    </div>
    -->
    <div>
        <!--1장 9절 조인 및 2장 1절 표준 조인-->
        <!--Q) 관람 기록 중 취소 내역을 찾아 고객 이름과 예매 번호를 찾아본다.-->
        <div>
            <h3>1장 9절 조인 및 2장 1절 표준 조인</h3>
            <h4>Q) 관람 기록 중 취소 내역을 찾아 고객 이름과 예매 번호를 찾아본다.</h4>
            <?php
            $q = $db->query('select customer.name "고객 이름", ticketing.id "예매 번호"
                            from customer, ticketing
                            where customer.cid = ticketing.cid and ticketing.status = "C";');
            $results = $q->fetchAll(PDO::FETCH_ASSOC);  
            ?>
            <table class="q1">
                <tr>
                    <td>고객 이름</td>
                    <td>예매 번호</td>
                </tr>
            <?php 
            foreach($results as $row){
                $name = $row["고객 이름"];
                $id = $row["예매 번호"];
                echo "<tr>
                            <td>$name</td>
                            <td>$id</td>
                    </tr>";
            }     
            ?>
            </table>
            <br>
        </div>
        
        <!--2장 5절 그룹 함수-->
        <!--Q) 티켓 상태(ticketing.status)를 기준으로 각 상태의 수를 집계한 GROUP BY SQL 문장을 수행한다.-->
        <div>
            <h3>2장 5절 그룹 함수</h3>
            <h4>Q) 티켓 상태(ticketing.status)를 기준으로 각 상태의 수를 집계한 GROUP BY SQL 문장을 수행한다.</h4>
            <?php
            $q = $db->query('select ticketing.status "티켓 상태", count(*)
                            from ticketing, schedule
                            where ticketing.sid = schedule.sid
                            group by ticketing.status;');
            $results = $q->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="q2">
                <tr>
                    <td>티켓 상태</td>
                    <td>총 합</td>
                </tr>
            <?php 
            foreach($results as $row){
                $status = $row["티켓 상태"];
                $count = $row["count(*)"];
                echo "<tr>
                            <td>$status</td>
                            <td>$count</td>
                    </tr>";
            }     
            ?>
            </table>
            <br>
        </div>

        <!--2장 6절 윈도우 함수-->
        <!--상영 정보(schedule.sid)를 기준으로 예매/취소/관람 전체 수를 집계한 GROUP BY SQL 문장을 수행하고 그 수가 높은 순으로 출력한다. 이때, 동일한 값이라면 SID를 오름차순하여 출력한다.-->
        <div>
            <h3>2장 6절 윈도우 함수</h3>
            <h4>상영 정보(schedule.sid)를 기준으로 예매/취소/관람 전체 수를 집계한 GROUP BY SQL 문장을 수행하고 그 수가 높은 순으로 출력한다. 이때, 동일한 값이라면 SID를 오름차순하여 출력한다.</h4>
            <?php
            $q = $db->query('select schedule.sid SID, 
                                count(*) "예매/취소/관람 수", 
                                rank() over (order by count(*) desc, schedule.sid asc) rank
                            from ticketing, schedule
                            where ticketing.sid = schedule.sid
                            group by schedule.sid;');
            $results = $q->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <table class="q2">
                <tr>
                    <td>스케줄 ID</td>
                    <td>예매/취소/관람 수 총 합</td>
                    <td>Rank</td>
                </tr>
            <?php 
            foreach($results as $row){
                $sid = $row["SID"];
                $count = $row["예매/취소/관람 수"];
                $rank = $row["rank"];
                echo "<tr>
                            <td>$sid</td>
                            <td>$count</td>
                            <td>$rank</td>
                    </tr>";
            }     
            ?>
            </table>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>
</html>