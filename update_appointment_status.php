<?php
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['appointment_id'], $_POST['status'])) {

    $id     = (int) $_POST['appointment_id'];
    $status = strtoupper($_POST['status']);           // keep DB values consistent

    

    $stmt = $conn->prepare(
        "UPDATE appointments SET status = ? WHERE appointment_id = ?"
    );
    $stmt->bind_param('si', $status, $id);

    if ($stmt->execute()) {
        echo 'Status updated';
    } else {
        http_response_code(500);
        echo 'Update failed';
    }
    $stmt->close();
} else {
    http_response_code(400);
    echo 'Bad request';
}
?>