<?php
session_start();
if (isset($_SESSION['username'])) {
    header("location:./dashboard");
}
else {
    header("location:./auth");
}