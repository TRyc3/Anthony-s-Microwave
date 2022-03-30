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

    $upload_ok = 0;
    //1: invalid user id (not an int)
    //2: user id not found
    //3: old password is incorrect
    //4: new password is invalid (confirmation doesn't match or isn't a string)

    //check if id is valid
    $user_id = (int) $_POST['user_id'];
    echo $user_id;
    if (is_int($user_id)){ //is int?
        $result = $db->query("SELECT id FROM users WHERE id = '$user_id'");
        if($result->num_rows == 0) { //exists in db?
            $upload_ok = 2;
        } 
    } else {
        $upload_ok = 1;
    }
    
    //check passwords
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $new_pass_conf = $_POST['new_pass_conf'];

    $sql = "SELECT password FROM users WHERE id = $user_id
    LIMIT 1";
    $result = $db->query($sql);
    $obj = $result->fetch_object();
    $value = $obj->password;

    if ($old_pass == $value){ //old password is correct
        if (is_string($new_pass) && $new_pass == $new_pass_conf){ //new passwords match 
            $user_pass = str_replace("'", "''", $new_pass);
        } else {
            $upload_ok = 4;
        }
    } else {
        $upload_ok = 3;
    }
    
    //upload new password
    if ($upload_ok == 0){
        $sql = "UPDATE users
        SET password = '$new_pass'
        WHERE id = '$user_id'";
        if ($db->query($sql) === TRUE) {
            echo "password updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        if ($upload_ok == 1) {
            echo "Error: invalid user id (not an int)";
        }
        if ($upload_ok == 2) {
            echo "Error: user id not found";
        }
        if ($upload_ok == 3) {
            echo "Error: old password is incorrect";
        }
        if ($upload_ok == 4) {
            echo "Error: new password is invalid (confirmation doesn't match or isn't a string)";
        }
    }