<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body class="bg">
<h1 class="anthonybox">Anthony's Microwave</h1>
<!-- Implements the graybox classes in external CSS -->
<?php
//if user is not logged in, displays options to log in or create a new account
if (!isset($_SESSION['user'])){ ?>
    <p class="grayboxLinks" style="text-align: center;"><a href="/anthony'smicrowave/user_test.html">Create user</a></p>
    <p class="grayboxLinks" style="text-align: center;"><a href="/anthony'smicrowave/login.html">Login</a></p>
<?php } else { 
    //if user is logged in, displays option to go to own user page,
    //create listing, change password, and log out
    $class = '"grayboxLinks"';
    $style = '"text-align: center;"';
    $link = "user_page.php?user_id=".$_SESSION['user'];
    echo "<p class=".$class." style=".$style."><a href=".$link.">User Page</a></p>";
    ?>
    <p class="grayboxLinks" style="text-align: center;"><a href="/anthony'smicrowave/listings_test.html">Create listing</a></p>
    <p class="grayboxLinks" style="text-align: center;"><a href="/anthony'smicrowave/pass_test.html">Change password</a></p>
    <p class="grayboxLinks" style="text-align: center;"><a href="/anthony'smicrowave/logout.php">Log Out</a></p>
<?php } ?>

<!-- <p class="grayboxLinks" style="text-align: center;"><a href="/pass_test.html">User Page</a></p> -->
<h1 style="text-align:center; font-size: 45px">Listings</h1>
<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Anthony'sMicrowave";
                
        $db = new mysqli($servername, $username, $password, $dbname);

        //search bar
        echo '<form action="" method="get">';    
        echo '<input type="search" id="search" name="search" placeholder="Search...">';
        echo '<input type="submit" value="Search..."></form>';
                  
        if (empty($_GET)){
            //create table of all listings in database
            $result = $db -> query("SELECT * FROM products");
        } else {
            //create results based on search
            $search  = $_GET['search'];
            $search = '%'.$search.'%';
            $result = $db -> query("SELECT * FROM products WHERE name LIKE '$search'");
        }


        $x = 0;
        echo '<table>';
        echo '<tr>';
        while($row = $result -> fetch_assoc()){
            //create rows of 3
            if($x < 3){
                $x++;
                //get url for image
                $item_url = '/images/'.$row['image'];
                $item_url = str_replace(" ", "%20", $item_url);
                //get url for unique item page
                $item_page = "item_page.php?item_id=".$row['item_id'];

                //get information of seller
                $seller_id = $row['seller'];
                $seller_page = "user_page.php?user_id=".$seller_id;
                $user = $db -> query("SELECT name FROM users WHERE user_id=$seller_id");
                $user = $user -> fetch_assoc();

                //display information
                echo "<td>";
                //Divider styling for the cells
                echo "<div class='cellDiv'>";
                echo "<a href = $item_page>
                      <img src=.$item_url class='images'>";
                echo "<header style='text-align: center; font-size: 40px'>" .$row['name']. '</header>';
                echo "<p style = 'text-align: center; font-size: 25px;'><a href = $seller_page>".$user['name']."</a></p>";
                //Styling for the description under the images
                echo '<p class="imagestxt">' .$row['description'].'<br>';
                echo "Price: $".$row['price'].'</p></div>';
            }
            else{
                echo '</tr>';
                echo '<tr>';
                $x = 0;
            }
        }
        echo '</table>';
?>
</body>
</html>
