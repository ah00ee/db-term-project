<?php
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

    function getTheaterScheduleR($db, $tname, $movie){
        $q = $db->query("SELECT theater.tname, movie.title, schedule.sdatetime, theater.seats FROM Schedule, theater, movie WHERE (schedule.tname=theater.tname AND theater.tname='$tname') AND schedule.mid=movie.mid AND (DATETIME(schedule.sdatetime)>=DATE('2022-05-05') AND DATETIME(schedule.sdatetime)<DATE('2022-06-05')) AND movie.title='$movie' ORDER BY movie.title;");
        $results = $q->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
?>
