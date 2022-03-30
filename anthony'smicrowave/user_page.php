<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<a href = "/anthony'smicrowave/index.php">
<h1 class="anthonybox">Anthony's Microwave</h1></a>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Anthony'sMicrowave";
            
    $db = new mysqli($servername, $username, $password, $dbname);

    $id = $_GET['user_id'];
    $result = $db -> query("SELECT name FROM users WHERE user_id='$id'");
    $name = $result -> fetch_assoc();
    echo "<header style='margin: 20; text-align:center; font-size:40px'>User: ".$name['name']."</header>";


    
    //if looking at someone elses user page, give option to leave reviews
    if (isset($_SESSION['user'])){
        if ($id != $_SESSION['user']){
                //form to create review
                $review_form = "/anthony'smicrowave/create_review.php";
                echo '<form action='.$review_form.' method="post" enctype="multipart/form-data">';
                echo '<label for="review"> Review:</label>';
                echo '<input type="text" id="review" name="review"><br><br>';
                echo '<input type="hidden" id="reviewer" name="reviewer" value="'.$_SESSION['user'].'"/>';
                echo '<input type="hidden" id="reviewee" name="reviewee" value="'.$id.'"/>';
                echo '<input type="submit" value="Submit"></form>';
            //if looking at own user page, give option to create listing and view messages
            } else { ?>
                <p class="grayboxLinks" style="text-align: center;"><a href="/anthony'smicrowave/listings_test.html">Create Listing</a></p>
            <?php 
                echo "<header style='margin: 20; text-align:left; font-size:30px'> Messages </header>";
                $recipient = $_SESSION['user'];
                $result = $db -> query("SELECT * FROM messages WHERE recipient='$recipient'");
                while($row = $result -> fetch_assoc()){
                    $sender_id = $row['sender'];
                    $sender_name = $db -> query("SELECT * FROM users WHERE user_id='$sender_id'");
                    $sender_name = $sender_name -> fetch_assoc();
                    $seller_page = "user_page.php?user_id=".$row['sender'];
                    echo "<h3><a href = $seller_page>".$sender_name['name']."</a></h3>";
                    echo '<p>'.$row['message']. '</p>';
                    
                    //create option to reply to messages
                    $message = "/anthony'smicrowave/message.php";
                    echo '<form action='.$message.' method="post" enctype="multipart/form-data">';    
                    echo '<input type="text" id="message" name="message"><br>';            
                    echo '<input type="hidden" id="recipient" name="recipient" value="'.$row['sender'].'"/>';
                    echo '<input type="hidden" id="sender" name="sender" value="'.$_SESSION['user'].'"/>';
                    echo '<input type="submit" value="Reply"></form><br>';
                }
            }
        } else {
            echo "<header style='margin: 20; text-align:left; font-size:20px'> Must be logged in to use these features </header>";
        }

    echo "<header style='margin: 20; text-align:left; font-size:30px'> Listings </header>";

    //display all item listings created by user
    $item = $db -> query("SELECT * FROM products WHERE seller = $id");
    $x = 0;
    while($row = $item -> fetch_assoc()){
        $url = '/images/'.$row['image'];
        $url = str_replace(" ", "%20", $url);
        $item_page = "item_page.php?item_id=".$row['item_id'];

        echo "<div style= 'display: block;
        border: 2.5px solid grey;
        background-color: rgb(235,235,235);
        height: 845px;
        width: auto;
        '>";

        echo "<a href = $item_page>
                <img src=.$url width = '200'>";
        echo '<h3 style="font-size:30px">' .$row['name']. '</h3><a>';
        echo '<p>' .$row['description']. '</p>';
        echo '<p> $' .$row['price'].  '</p>';
    }

    echo "<div>";
    echo "<header style='margin: 100px; text-align:center; font-size:30px'> Reviews </header>";

    //display all reviews of user
    $review = $db -> query("SELECT * FROM reviews WHERE reviewee = $id");
    while($row = $review -> fetch_assoc()){
        $reviewer = $row['reviewer'];
        $reviewer_page = "user_page.php?user_id=".$reviewer;
        $user = $db -> query("SELECT name FROM users WHERE user_id=$reviewer");
        $user = $user -> fetch_assoc();
        echo "<a href = $reviewer_page>";
        echo "<header>".$user['name']."</header></a>";
        echo "<p>".$row['review']."</p><br>";
    }
    echo "</div>";
?>
</html>