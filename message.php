<?php
    //connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Anthony'sMicrowave";

    $db = new mysqli($servername, $username, $password, $dbname);

    if ($db -> connect_error){
        die("Connection failed: " . $db->connect_error);
    }

    $upload_ok = 1;

    //check if valid review
    $message = $_POST['message'];
    if (is_string($message)){
        $message = str_replace("'", "''", $message);
    } else {
        $upload_ok = 0;
    }

    //checks for valid input
    $sender = (int)$_POST['sender'];
    if (!is_int($sender)){
        $upload_ok = 0;
    }

    //checks for valid input
    $recipient = (int)$_POST['recipient'];
    if (!is_int($recipient)){
        $upload_ok = 0;
    }

    //if upload is ok, add to database
    if ($upload_ok == 1){
        $sql = "INSERT INTO messages VALUES 
        ('$recipient', '$sender', '$message')";
        if ($db->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        echo "Message failed";
    }
?>
