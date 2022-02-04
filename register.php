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
    <title>Registration</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row bg-secondary">
            <div class="col">
                <h1 class="my-5 text-center text-white">Image Gallery Generator</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 px-4 mb-4">
                <h2 class="mt-5 mb-5 mx-5">Registration</h2>
                <?php
                // set the variable when the page loads
                $first_name = null;
                $last_name = null;
                $email = null;
                $password = null;
                $error_bucket = [];

                // if it is a POST, then check the form to see if the user left any fields blank. If so, add error message(s) to the error bucket. If not, assign the data in the form fields to the variables.
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    if (empty($_POST['firstName'])) {
                        array_push($error_bucket, "A First Name is required.");
                    } else {
                        $first_name = $_POST['firstName'];
                    }

                    if (empty($_POST['lastName'])) {
                        array_push($error_bucket, "A Last Name is required.");
                    } else {
                        $last_name = $_POST['lastName'];
                    }

                    if (empty($_POST['email'])) {
                        array_push($error_bucket, "An Email is required.");
                    } else {
                        $email = $_POST['email'];
                    }

                    if (empty($_POST['password'])) {
                        array_push($error_bucket, "A Password is required.");
                    } else {
                        $password = hash('sha512', $_POST['password']);
                    }

                    // if there are no errors, then send the data from the form to the database using SQL statement to create a new record for the user
                    if (count($error_bucket) == 0) {
                        $sql = "INSERT INTO user (first_name, last_name, email, password)";
                        $sql .= "VALUES (:first_name, :last_name, :email, :password)";

                        $stmt = $db->prepare($sql);
                        // checks to make sure the email they entered is not a duplicate email to one already in the database. If its a duplicate, then display error message
                        try {
                            $stmt->execute(["first_name" => $first_name, "last_name" => $last_name, "email" => $email, "password" => $password]);
                        } catch (PDOException $e) {
                            if ($e->errorInfo[1] == 1062) {
                                echo "<div class='alert alert-info mt-2 mb-3 mx-5 pt-3 pb-2 px-3' role='alert'>";
                                echo "<p class='fs-5'>There was a problem with your registration. Please try again.</p>";
                                echo "</div>";
                                $error = true;
                                unset($_POST['firstName']);
                                unset($_POST['lastName']);
                                unset($_POST['email']);
                            }
                        }
                        // if there is no duplicate error and the SQL statement does not create a row/new record, then display an error message
                        if (!isset($error)) {
                            if ($stmt->rowCount() == 0) {
                                echo "There was a problem with your registration.";
                            } else {
                                // if a row was create and registration was successful, then display success message and give user link to log in page.
                                echo "<div class='alert alert-info mt-3 mb-3 mx-5 pt-3 pb-2 px-3' role='alert'>";
                                echo "<p class='fs-5'>You are now registered. Please login to continue. <a href='login.php' title='Login' class='btn btn-success fs-5 ms-5'>Log In</a></p>";
                                echo "</div>";
                                // clear the sticky form fields
                                unset($_POST['firstName']);
                                unset($_POST['lastName']);
                                unset($_POST['email']);
                            }
                        }
                        // if there are errors in the error bucket, then display the errors
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
                <form class="mt-5" action="register.php" method="POST">
                    <div class="mb-3 mx-5">
                        <label class="form-label fs-5" for="first">First Name</label>
                        <input class="form-control" type="text" name="firstName" id="first" value="<?= (isset($_POST['firstName'])) ? $_POST['firstName'] : ''; ?>">
                    </div>
                    <div class="mb-3 mx-5">
                        <label class="form-label fs-5" for="last">Last Name</label>
                        <input class="form-control" type="text" name="lastName" id="last" value="<?= (isset($_POST['lastName'])) ? $_POST['lastName'] : ''; ?>">
                    </div>
                    <div class="mb-3 mx-5">
                        <label class="form-label fs-5" for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" value="<?= (isset($_POST['email'])) ? $_POST['email'] : ''; ?>">
                    </div>
                    <div class="mb-4 mx-5">
                        <label class="form-label fs-5" for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <div class="mb-3 mx-5">
                        <button class="btn btn-success fs-5" type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>