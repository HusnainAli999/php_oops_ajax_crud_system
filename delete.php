<?php
include "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mainObj->delete("products_table", ["id"], [$_GET['pro_id']], 'i');
    echo "<script> window.location.href='index.php'; </script>";
}
