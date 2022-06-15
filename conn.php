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

    function getMovieDetail($db, $t){
        #open_day
        $o = $db->query("SELECT open_day FROM movie WHERE title='$t';");
        $results_o = $o->fetchAll(PDO::FETCH_ASSOC);
        
        #close_day
        $c = $db->query("SELECT s.mid, MAX(s.sdatetime) as lastdate FROM schedule s GROUP BY s.mid");
        $results_c = $c->fetchAll(PDO::FETCH_ASSOC);
        return array($results_o, $results_c);
    }
?>
