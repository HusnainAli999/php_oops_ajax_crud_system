<?php
include "database.php";

$pro_id = isset($_POST['pro_id']) ? $_POST['pro_id'] : '';
$title = isset($_POST['title']) ? $_POST['title'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';

if (isset($_POST['submit_update_data'])) {

    if (is_numeric($price) === FALSE) {
        echo "<h1 class='alert_h1'>Price is Not Numeric</h1>";
        exit;
    }

    $mainObj->update("products_table", ["title", "price"], [$_POST['title'], $_POST['price'], $_POST['pro_id']], "ssi", ["id"]);
    echo "<script> window.location.href='index.php'; </script>";
}
?>
<form action="" method="POST" id="update_form">
    <input type="hidden" name="pro_id" value="<?php echo $pro_id; ?>">

    <div>
        <label>Product title</label><br>
        <input type="text" name="title" value='<?php echo $title; ?>' required>
    </div>

    <div>
        <label>Product Price</label><br>
        <input type="text" name="price" value='<?php echo $price; ?>' required>
    </div>

    <div>
        <button type="submit" name='submit_update_data'>Update</button>
    </div>
</form>