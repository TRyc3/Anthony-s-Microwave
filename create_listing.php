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

    $upload_ok = 1;

    //check if name is valid
    $name = $_POST['name'];
    if (is_string($name)){
        $name = str_replace("'", "''", $name);
    } else {
        $upload_ok = 0;
    }

    //check if description is valid
    $description = $_POST['description'];
    if (is_string($description)){
        $description = str_replace("'", "''", $description);
    } else {
        $upload_ok = 0;
    }

    //check if image is valid
    $file_type = $_FILES['image']['type'];
    if($file_type != "image/jpg" && $file_type != "image/png" && $file_type != "image/jpeg"){
        $upload_ok = 0;
    } else {
        $file_name = $_FILES['image']['name'];
    }

    //check if price is valid
    $price = (int)$_POST['price'];
    if (!is_int($price)){
        $upload_ok = 0;
    }


    //if all input is valid
    if ($upload_ok){        
        //TO DO: get seller id from page 
        $seller = $_SESSION['user'];

        //create image
        if (!file_exists('images')) {
            mkdir('images', 0777, true);
        }
        $temp_name = $_FILES["image"]["tmp_name"];
        $image_folder = "images/".$file_name;
        move_uploaded_file($temp_name, $image_folder);

        //insert all values into 'products' table
        $sql = "INSERT INTO products (name, description, seller, image, price) VALUES 
           ('$name', '$description', '$seller', '$file_name', '$price')";

        if ($db->query($sql) === TRUE) {
            echo "New record created successfully";
            header("Location: http://localhost/anthony'smicrowave/index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        echo "Error: invalid input";
    }
        
    $db -> close();
?>
