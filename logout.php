<?php
// destroys the session and redirects user to the home page
session_start();
session_destroy();
header('Location: create_gallery.php');
