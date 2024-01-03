<?php

class DataBase
{
    private $conn = '';
    private $currentPage;
    public $recordsPerPage;

    function __construct($host, $user, $password, $database)
    {
        $this->conn = new mysqli($host, $user, $password, $database);
        if (!$this->conn) {
            echo "Major Connection Failed in database.php ON " . __LINE__ . mysqli_connect_error();
            exit;
        }
    }

    function insert($tableName, $columnNames = array(), $values = array(), $dataTypes, $insertSuccessMessage = '', $insertFailMessage = '')
    {
        $stringColumns = implode(", ", $columnNames);

        $dataTypesCount = array_fill(0, count($columnNames), '?');
        $dataTypesCount = implode(", ", $dataTypesCount);

        if (empty($insertFailMessage)) {
            $insertFailMessage = "Failed To Insert";
        }

        $insertSuccessMessage = empty($insertSuccessMessage) ? 'Data Inserted Successfully' : $insertSuccessMessage;

        $stmt = mysqli_prepare($this->conn, "INSERT INTO $tableName ($stringColumns)  VALUES ($dataTypesCount)");
        $stmt->bind_param($dataTypes, ...$values);

        if ($stmt->execute()) {
            echo "<h1 class='alert_h1'> $insertSuccessMessage </h1>";
        } else {
            echo "<h1 class='alert_h1'> $insertFailMessage </h1>";
        }
    }

    function delete($table, $columnNames = array(), $values = array(), $dataTypes)
    {
        $deleteQuery = "DELETE FROM $table";

        $whereClauseLogic = array_map(function ($col) {
            return $col . ' = ?';
        }, $columnNames);

        $whereClauseLogic = implode(" AND ", $whereClauseLogic);

        $deleteQuery .= " WHERE $whereClauseLogic";

        $stmt = $this->conn->prepare($deleteQuery);
        $stmt->bind_param($dataTypes, ...$values);

        if ($stmt->execute()) {
            echo "<h1 class='alert_h1'> Data Delete Successfully </h1>";
        } else {
            echo "<h1 class='alert_h1'> Failed To Delete Data </h1>";
            exit;
        }
    }

    function update($table, $columnNames = array(), $values = array(), $dataTypes, $whereClause = array(), $updateSuccessMessage = '', $updateFailMessage = '')
    {

        $updateColumnsLogic =  array_map(function ($col) {
            return $col . ' = ? ';
        }, $columnNames);

        $updateColumnsLogic = implode(", ", $updateColumnsLogic);

        $whereClauseLogic = array_map(function ($col) {
            return $col . " = ?";
        }, $whereClause);

        $whereClauseLogic = implode(" AND ", $whereClauseLogic);


        $query = "UPDATE $table SET $updateColumnsLogic";

        if (!empty($whereClause)) {
            $query .= " WHERE $whereClauseLogic";
        }

        if (empty($updateSuccessMessage)) {
            $updateSuccessMessage = 'Data Update Sucessfully';
        }

        $updateFailMessage = empty($updateFailMessage) ? $updateFailMessage : 'Data Failed To Update';

        $stmt = mysqli_prepare($this->conn, $query);
        $stmt->bind_param($dataTypes, ...$values);
        if ($stmt->execute()) {
            echo "<h1 class='alert_h1'> $updateSuccessMessage </h1>";
        } else {
            echo "<h1 class='alert_h1'> $updateFailMessage </h1>";
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

    public function getRecords($table, $columnNames = array(), $values = array(), $dataTypes = '', $whereClauseColumns = array(), $joins = '', $orderClause = '', $limit = '', $recordsPerPage)
    {
        $this->currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->recordsPerPage = $recordsPerPage;
        $offset = ($this->currentPage - 1) * $this->recordsPerPage;
        $result = $this->select($table, $columnNames, [...$values, $offset, $this->recordsPerPage], ($dataTypes . 'ii'), $whereClauseColumns, $joins, $orderClause, '?, ?', $recordsPerPage);
        return $result;
    }


    public function displayPaginationLinks($table, $values = array(), $dataTypes = '', $whereClauseColumns = array(), $joins = '',)
    {
        $totalRecords = $this->select($table, ['COUNT(*) as count'], $values, $dataTypes, $whereClauseColumns, $joins)->fetch_assoc()['count'];

        $totalPages = ceil($totalRecords / $this->recordsPerPage);

        $previousPage = ($this->currentPage - 1);

        if ($previousPage == 0) {
            $previousPage = 1;
        }

        echo "<div class='main_pagination_div'>";

        echo "<a href='?page=1' class='first_pagination_a'>First</a>";
        echo "<a href='#' data-page='$previousPage' class='previous_pagination_a pagination-link'>Previous</a>";

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $this->currentPage) {
                $class = 'pagination_a pagination-link active';
            } else {
                $class = 'pagination_a pagination-link';
            }

            if (
                $i == 1 ||
                $i == $totalPages ||
                $i == $this->currentPage ||
                ($i >= $this->currentPage - 2 && $i <= $this->currentPage + 2)
            ) {
                echo "<a href='#' data-page='$i' class='$class'>$i</a> ";
            } else if ($i == $this->currentPage - 3 || $i == $this->currentPage + 3) {
                echo "<span class='ellipses'> ... </span>";
            }
        }

        if ($this->currentPage < $totalPages) {
            $nextPage = ($this->currentPage + 1);
        } else {
            $nextPage = $totalPages;
        }

        echo "<a href='#' data-page='$totalPages' class='last_pagination_a pagination-link'>Last</a>";
        echo "<a href='#' data-page='$nextPage' class='next_pagination_a pagination-link'>Next</a>";

        echo "</div>";
    }
}

$mainObj = new DataBase("localhost", "root", "", "oops_crud_database");