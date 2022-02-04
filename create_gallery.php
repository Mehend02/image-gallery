<?php
session_start();
require "inc/functions.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Image Gallery Generator</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row bg-secondary">
            <div class="col">
                <h1 class="my-5 text-center text-white">Image Gallery Generator</h1>
            </div>
        </div>
        <div class="row">
            <?php
            // if the user is logged in, display welcome message with the user's first name and a log out button, and the application will display below this
            if (isset($_SESSION["loggedin"])) {
                echo "<div class='col-12 px-4'>";
                echo "<h2 class='mt-5 mb-4 ms-5 text-center d-flex justify-content-between'>Welcome to the Image Gallery Generator, " . $_SESSION["first_name"] . "! <a href='logout.php' title='Log out' class='btn btn-success mx-5'>Log Out</a></h2>";
                echo "</div>";
                // if the user is not logged in, display a welcome message telling user they need to register and log in. Display register and login buttons
            } else {
                echo "<div class='col-12 col-lg-6 px-4'>";
                echo "<h2 class='mt-5 mx-5'>Welcome to the Image Gallery Generator</h2>";
                echo "<p class='mt-5 mx-5 fs-4'>Upload your favorite photos and easily create an image gallery to display them.</p>";
                echo "<p class='mt-5 mx-5 fs-4'>In order to use this application, you need to be a registered user. If you are a new user, please register first to create an account. If you are a returning user, please log in.</p>";
                echo "<div class='ms-5 my-5'>";
                echo "<a href='register.php' title='Register' class='btn btn-success fs-5 me-3 px-4'>Register</a>";
                echo "<a href='login.php' title='Login' class='btn btn-success fs-5 ms-3 px-4'>Log In</a>";
                echo "</div>";
                echo "</div>";
                require "inc/examplegallery.inc.html";
            }
            ?>
        </div>
        <!-- if the user is not logged in, kill the script so they user can't access the application -->
        <?php
        if (!isset($_SESSION["loggedin"])) {
            die();
        }
        ?>
        <div class="row">
            <div class="col-12 col-lg-6 px-4">
                <p class="mt-5 mx-5 fs-4">Upload your favorite photos and create an image gallery to display them. You can upload images into various folders to generate multiple image galleries. Your galleries will display below. To enlarge a photo, simply click on the image.</p>

                <?php
                $message = processUploadedFile();
                displayMessage($message);
                deleteImage();

                require "inc/form.inc.php";
                ?>
            </div>
            <?php
            require "inc/examplegallery.inc.html";
            ?>
        </div>


        <div class="row gallery px-5">
            <div class="col-12">
                <?php
                displayImages('people');
                displayImages('pets');
                displayImages('vacation');
                displayImages('miscellaneous');
                ?>
            </div>
        </div>
        <div class="row footer py-4">
            <div class="col">
                <footer class="text-center fs-6 my-4">Copyright 2021 Melanie Henderson</footer>
            </div>
        </div>
    </div>
</body>

</html>