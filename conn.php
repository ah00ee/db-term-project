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
?>