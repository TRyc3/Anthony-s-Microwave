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
    //1: invalid name
    //2: invalid password
    //3: invalid file

    //check if name is valid
    $name = $_POST['name'];
    if (is_string($name)){
        $name = str_replace("'", "''", $name);
    } else {
        $upload_ok = 1;
    }
    
    //check if password is valid
    $user_pass = $_POST['user_pass'];
    $pass_conf = $_POST['pass_conf'];
    if (is_string($user_pass) && $user_pass == $pass_conf){ 
        $user_pass = str_replace("'", "''", $user_pass);
    } else {
        $upload_ok = 2;
        
    }

    //check if image is valid
    $file_type = $_FILES['image']['type'];
    if($file_type != "image/jpg" && $file_type != "image/png" && $file_type != "image/jpeg"){
        $upload_ok = 3;
    } else {
        $file_name = $_FILES['image']['name'];
    }

    //if all input is valid
    if ($upload_ok == 0){
 
        //create image
        if (!file_exists('images')) {
            mkdir('images', 0777, true);
        }
        $temp_name = $_FILES["image"]["tmp_name"];
        $image_folder = "images/".$file_name;
        move_uploaded_file($temp_name, $image_folder);
     
        //insert all values into 'users' table
        $sql = "INSERT INTO users (name, image, password) VALUES 
           ('$name', '$file_name', '$user_pass')";
  
        if ($db->query($sql) === TRUE) {
            echo "New record created successfully";
            $sql = "SELECT user_id FROM users WHERE name= '$name'";
            $result = $db -> query($sql);
            $row = $result -> fetch_assoc();
            $_SESSION['user'] = $row['user_id'];
            header("Location: http://localhost/anthony'smicrowave/index.php");
            die();
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }

    } else {
        if ($upload_ok == 1) {
            echo "Error: invalid name";
        }
        if ($upload_ok == 2) {
            echo "Error: invalid password";
        }
        if ($upload_ok == 3) {
            echo "Error: invalid file";
        }
    }
        
    $db -> close();
?>
