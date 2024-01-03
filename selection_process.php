<?php
include "css.php";
include "database.php";

$titleSearch = isset($_GET['title']) ? $_GET['title'] : '';
$priceSearch = isset($_GET['price']) ? $_GET['price'] : '';

$limit = 3;

if ($titleSearch != '') {
    $result = $mainObj->getRecords("products_table", ["*"], [$titleSearch], 's', ['title'], '', '', '', $limit);
} else if ($priceSearch != '') {
    $result = $mainObj->getRecords("products_table", ["*"], [$priceSearch], 'i', ['price'], '', '', '', $limit);
} else {
    $result = $mainObj->getRecords("products_table", ["*"], [], '', [], '', '', '', $limit);
}


echo "<table>";
echo "<tr>
<th>Product Title</th>
<th>Product Price</th>
<th>Delete</th>
<th>Update</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {

    if (strlen($row['title']) >= 90) {
        $title = substr($row['title'], 0, 90) . '...';
    } else {
        $title = $row['title'];
    }

    echo "<tr>";
    echo "<td>" . $title . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td> <a href='delete.php?pro_id=" . $row['id'] . " ' class='delete_a'>Delete</a> </td>";
    echo "<td> <form method='POST' action='update.php' id='insertForm'>
       <input type='hidden' value='" . $row['id'] . "' name='pro_id'/>
       <input type='hidden' value='" . $row['title'] . "' name='title' />
       <input type='hidden' value='" . $row['price'] . "' name='price' />
       <button type='submit'>Update</button>
    </form> </td>";
    echo "</tr>";
}
echo "</table>";


if ($titleSearch != '') {
    echo $mainObj->displayPaginationLinks("products_table", [$titleSearch], 's', ['title'], '');
} else if ($priceSearch != '') {
    echo $mainObj->displayPaginationLinks("products_table", [$priceSearch], 'i', ['price'], '');
} else {
    echo $mainObj->displayPaginationLinks("products_table", [], '', [], '');
}
