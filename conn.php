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

    function getTheaterSchedule($db, $tname){
        $q = $db->query("SELECT theater.tname, movie.open_day, movie.title, schedule.sdatetime, theater.seats FROM Schedule, theater, movie where (schedule.tname=theater.tname and theater.tname='$tname') and schedule.mid=movie.mid and datetime(movie.open_day)>date('2022-05-01');");
        $results = $q->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
?>