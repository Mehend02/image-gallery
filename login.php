<?php
session_start();
require "inc/db_connect.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login Page</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row bg-secondary">
            <div class="col-12">
                <h1 class="my-5 text-center text-white">Image Gallery Generator</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 px-4 mb-4">
                <h2 class="mt-5 mb-5 mx-5">Log In</h2>
                <?php
                // set the variable when the page loads
                $email = null;
                $password = null;
                $error_bucket = [];

                // if it is a POST, then check to see if the user left an fields blank. If so, add the error messages to the error bucket. If not, assign the data in the form fields to the variables.
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if (empty($_POST["email"])) {
                        array_push($error_bucket, "Please enter a your email address.");
                    } else {
                        $email = $_POST["email"];
                    }
                    if (empty($_POST["password"])) {
                        array_push($error_bucket, "Please enter your password.");
                    } else {
                        $password = hash("sha512", $_POST["password"]);
                    }

                    // if there are no errors on the form, then query the database to retrieve the record where the email and password entered on the log in form match the email and password of the database record.
                    if (count($error_bucket) == 0) {
                        $sql = "SELECT * FROM user WHERE email=:email AND password=:password LIMIT 1";
                        $stmt = $db->prepare($sql);
                        $stmt->execute(["email" => $email, "password" => $password]);

                        // if 1 record was returned, set the session variables for the user and redirect the user to the application
                        if ($stmt->rowCount() == 1) {
                            $_SESSION["loggedin"] = 1;
                            $_SESSION["email"] = $email;
                            // get the first and last name from the database record
                            $row = $stmt->fetch();
                            $_SESSION["first_name"] = $row->first_name;
                            $_SESSION["last_name"] = $row->last_name;
                            header("Location: create_gallery.php");
                        } else {
                            // if there was no matching record in the database, display an error message.
                            echo "<div class='alert alert-info mt-2 mb-3 mx-5 pt-3 pb-2 px-3' role='alert'>";
                            echo "<p class='fs-5'>That email and password did not work correctly. Please try again.</p>";
                            echo "</div>";
                        }
                        // if there are errors in the error bucket, display the errors
                    } else {
                        echo "<div class='alert alert-info mt-2 mb-3 mx-5 pt-3 pb-2 px-3' role='alert'>";
                        echo "<ul>";
                        foreach ($error_bucket as $error) {
                            echo "<li class='fs-5'>$error</li>";
                        }
                        echo "</ul></div>";
                    }
                }
                ?>
                <form class="mt-4" action="login.php" method="POST">
                    <div class="mb-3 mx-5">
                        <label class="form-label fs-5" for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email">
                    </div>
                    <div class="mb-4 mx-5">
                        <label class="form-label fs-5" for="password">Password</label>
                        <span class="ms-4 text-decoration-underline" id="showPassword" onclick="showPassword()">Show Password</span>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <div class="mb-3 mx-5">
                        <button class="btn btn-success fs-5" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>