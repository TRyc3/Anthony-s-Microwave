<?php
    session_start();

    //connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Anthony'sMicrowave";

    $db = new mysqli($servername, $username, $password, $dbname);

    if ($db -> connect_error){
        die("Connection failed: " . $db->connect_error);
    }

    $upload_ok = 0;

    //check if name is valid
    $name = $_POST['name'];
    if (is_string($name)){
        $name = str_replace("'", "''", $name);
    } else {
        $upload_ok = 1;
    }
    
    //check if password is valid
    $password = $_POST['password'];
    if (is_string($password)){ 
        $password = str_replace("'", "''", $password);
    } else {
        $upload_ok = 2;
        
    }

    //if all input is valid check if password and username are correct
    if ($upload_ok == 0){
        $result = $db -> query("SELECT * FROM users WHERE name = '$name'");
        $row = $result -> fetch_assoc();
        if ($row['password'] == $password){
            //if login is succesful, redirect to homepage
            $_SESSION['user'] = $row['user_id'];
            header("Location: http://localhost/anthony'smicrowave/index.php");
        } else {
            echo "Incorrect name or password";
        }
    }
        
    $db -> close();
?>