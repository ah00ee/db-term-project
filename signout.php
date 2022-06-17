<?php
    include('conn.php');
    session_destroy();
    header('Location:signin.php');
?>