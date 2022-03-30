<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>
<h1 class="anthonybox"></h1>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Anthony'sMicrowave";
            
    $db = new mysqli($servername, $username, $password, $dbname);
                
    $result = $db -> query("SELECT * FROM products");

    //loop through all values in table and print to page
    while ($row = $result -> fetch_assoc()){
        //Size of image is set to 20px of screen, and kept at the right
        echo '<br><img src ="' .$row['image']. ' alt = ' .$row['item_id']. '">';
        
        // Keep the name of the item a little bit spaced from the left
        //The name of the product is on the top left, in big font, independent of window
        echo "<header style='text-align: left; font-size: 40px; padding-left: 50px;'>" .$row['name']. '</header>';
        
        //The description of the product, encapsulated in a class
        echo "<p class='imagestxt'>" .$row['description']. '</p>';
        
        //Price, kept at left
        echo "<p style='font-size: 20px;
        text-align: left;
        height: 15px;
        width: 50px;
        padding: 5px;
        border: 10px;
        margin: 50px;'>" .$row['price'].  '</p>';
    }

?>
