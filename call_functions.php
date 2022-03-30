<?php

    //list of various blocks to call different data from sql table

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Anthony'sMicrowave";
            
    $db = new mysqli($servername, $username, $password, $dbname);

    //pull array of all rows in products
    $sql = "SELECT * FROM products";
    $result = $db -> query($sql);

    //pull single row using item id
    $id = 0; //replace 0 with actual id
    $sql = "SELECT * FROM products WHERE item_id = $id";
    $result = $db -> query($sql);
    $row = $result -> fetch_assoc();
    //example: print name of product
    // echo $row['name'];

    //pull single piece of information from item using item id
    $id = 0; //replace 0 with actual id
    $search = "name"; //replace name with desired column
    $sql = "SELECT $search FROM products WHERE item_id = $id";
    $result = $db -> query($sql);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    //example: print name of product
    //echo $row['name'];

    //pull user using user id
    // $id = 0; //replace 0 with actual id
    // $sql = "SELECT * FROM users WHERE item_id = $id";
    // $result = $db -> query($sql);
    // $row = $result -> fetch_assoc();
    //example: print name of product
    // echo $row['name'];

    //pull all reviews of user
    $user = 1; //replace 1 with actual user
    $sql = "SELECT reviews FROM reviews WHERE reviewee = $user";
    $result = $db -> query($sql);
    $row = $result -> fetch_assoc();
    //example: print review
    // echo $row['review'];

    //pull all reviews made by user
    $user = 1; //replace 1 with actual user
    $sql = "SELECT reviews FROM reviews WHERE reviewer = $user";
    $result = $db -> query($sql);
    $row = $result -> fetch_assoc();
    //example: print review
    // echo $row['review'];


?>
