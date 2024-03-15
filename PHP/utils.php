<?php

function checksDuplicity($mysqli, $table, $column, $value) {
    $sql = "SELECT * FROM $table WHERE $column = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

?>
