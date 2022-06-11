<?php

$db = new PDO('sqlite:tp.db') or die("cannot open the database");
echo "BYE";
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($db->lastErrorCode() == 0){
	echo "Database connection succeed!";
}
else {
	echo "Database connection failed";
    echo $db->lastErrorMsg();
}

//$results = $db->query("insert into VAN  (VANCode , VANName) values ('6','test')");
$results = $db->query("select * from Customer;");

while ($row = $results->fetchArray()) {

    //var_dump($row);
	echo $row[0]."---".$row[1]."<br/>";
}

exit;
?>