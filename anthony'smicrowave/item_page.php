<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<a href = "/anthony'smicrowave/index.php">
<h1 class = "anthonybox">Anthony's Microwave</h1></a>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Anthony'sMicrowave";
            
    $db = new mysqli($servername, $username, $password, $dbname);

    $id = $_GET['item_id'];
                
    $result = $db -> query("SELECT * FROM products WHERE item_id = $id");

    //display item informations
    $row = $result -> fetch_assoc();
    $item_url = '/images/'.$row['image'];
    $item_url = str_replace(" ", "%20", $item_url);
    // echo "<div><img src=.$item_url width = '400'>";
    // echo '<header>'.$row['name'].'</header>';

    //Inline styling for the whole block, making gray background
    echo "<div style= 'display: block;
    border: 2.5px solid grey;
    background-color: rgb(235,235,235);
    height: 845px;
    width: auto;
    // Uncomment if you want a different layout, stuff on right, picture on left
    // display: flex;
    // justify-content: center;
    '>";
    //Inline styling for the image, just to center it
    echo "<img src=.$item_url class = 'div images'>";

    echo "<header style='text-align: center; font-size: 40px'>".$row['name'].'</header>';
    echo '<p style = "text-align: center; font-size: 25px;">'.$row['description'].'</p>';
    echo '<p style = "font-size: 45px; color: black; text-align:center;">',"Price: $".$row['price'].'</p> <div>';
    
    //link to sellers user page
    $seller_id = $row['seller'];
    $seller_page = "user_page.php?user_id=".$seller_id;
    $user = $db -> query("SELECT name FROM users WHERE user_id=$seller_id");
    $user = $user -> fetch_assoc();
    echo "<p style='font-size:30px'><a href = $seller_page>".$user['name']."</a></p><br>";

    //message seller if logged in
    if (isset($_SESSION['user'])){
        $id = $_SESSION['user'];
        $result = $db -> query("SELECT name FROM users WHERE user_id='$id'");
        $buyer_name = $result -> fetch_assoc();
        $message = "/anthony'smicrowave/message.php";
        echo '<form action='.$message.' method="post" enctype="multipart/form-data">';    
        $contents = $buyer_name['name']." is interested in purchasing ".$row['name'];
        echo '<input type="hidden" id="message" name="message" value="'.$contents.'"/>';
        echo '<input type="hidden" id="recipient" name="recipient" value="'.$row['seller'].'"/>';
        echo '<input type="hidden" id="sender" name="sender" value="'.$_SESSION['user'].'"/>';
        echo '<input type="submit" value="Buy"></form>';
    } else {
        echo "<p> Must be logged in to purchase </p>";
    }

?>
</html>