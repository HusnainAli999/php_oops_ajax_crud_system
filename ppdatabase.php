<?php
include "css.php";

class DataBase
{
    private $conn = '';

    function __construct($host, $user, $password, $database)
    {
        $this->conn = new mysqli($host, $user, $password, $database);
        if (!$this->conn) {
            echo "Major Connection Failed " . mysqli_connect_error();
            exit;
        }
    }

    function select($table, $columnNames = array(), $values = array(), $dataTypes = '', $whereClause = array(), $joins = '', $orderClause = '', $limit = '')
    {
        $stringColumnNames = implode(", ", $columnNames);
        $query = "SELECT $stringColumnNames FROM $table";

        if (!empty($joins)) {
            $query .= " $joins";
        }

        $whereClause = array_map(function ($col) {
            return $col . ' = ? ';
        }, $whereClause);

        $whereClause = implode(" AND ", $whereClause);


        if (!empty($whereClause)) {
            $query .= " WHERE $whereClause";
        }

        if (!empty($orderClause)) {
            $query .= " ORDER BY $orderClause";
        }

        if (!empty($limit)) {
            $query .= " LIMIT $limit";
        }

        $stmt = $this->conn->prepare($query);

        try {

            if ($stmt === FALSE) {
                throw new Exception("Error In Stmt In Select Command First Stage");
            }

            if (!empty($values) && !empty($dataTypes)) {
                $stmt->bind_param($dataTypes, ...$values);
            }

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result === FALSE) {
                throw new Exception("Error in Get Result Function In Selection");
            }

            return $result;
        } catch (Exception $e) {
            if ($e->getMessage() == "No data supplied for parameters in prepared statement") {
            } else {
                echo $e->getMessage();
            }
            return false;
        }
    }
}

$mainObj = new DataBase("localhost", "root", "", "oops_crud_database");

$result = $mainObj->select("products_table", ["*"], ['car', 89], 'si', ["title", "price"], '', '', 10);

while ($row = mysqli_fetch_assoc($result)) {
    echo $row['title'] . "<br>";
}
