<!--php 함수 사용을 위한 페이지-->
<!--
    session_start()를 통해 로그인 세션 유지.
    데이터베이스 연결이 이루어짐.
    다른 .php 파일에서 include('conn.php'); 후 $db 사용 가능.
-->
<?php
    session_start();
    $conn = FALSE;
    if(isset($_SESSION["ID"])){
        $conn = TRUE;
    }

	try {
		$db = new PDO('sqlite:tp.db') or die("cannot open the database");
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

    function getUserName($db, $email, $pwd){
        $q = $db->query("SELECT name FROM Customer WHERE email='$email' AND password='$pwd';");
        $results = $q->fetchAll(PDO::FETCH_ASSOC);
        return $results[0]["name"];
    }

    function getTheaterScheduleR($db, $tname, $movie, $date){
        $q = $db->query("SELECT theater.tname, schedule.sid, schedule.sdatetime, theater.seats 
                            FROM schedule, theater, movie 
                            WHERE (schedule.tname=theater.tname AND theater.tname='$tname') 
                            AND (schedule.mid=movie.mid AND movie.title='$movie') 
                            AND (DATE(schedule.sdatetime)=DATE('$date'));"
                        );
        $results = $q->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
?>
