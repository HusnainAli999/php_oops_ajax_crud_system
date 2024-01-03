<?php
include "database.php";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mainObj->insert("products_table", ["title", "price"], [$_POST['title'], $_POST['price']], "si");
    echo "<script> window.location.href='index.php'; </script>";
}