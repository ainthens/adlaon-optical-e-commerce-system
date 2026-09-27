<?php
 include('conn.php');
 $fullName = $_POST['fullName'];
 $email = $_POST['email'];
 $phone = $_POST['phone'];
 $date = $_POST['date'];
 $time = $_POST['time'];
 $notes = $_POST['notes'];
 $services = $_POST['services'];
 $status = "Pending";

 $stmt = $conn->prepare("insert into appointments (patient_name, email, phone, appoint_date, appoint_time, services_selected, notes, status) values (?, ?, ?, ?, ?, ?, ?, ?)");
 $stmt->bind_param("ssssssss", $fullName, $email, $phone, $date, $time, $services, $notes, $status);
 
 if ($stmt->execute()) {
     echo "Appointment saved successfully!";
 } else {
     echo "Error: " . $stmt->error;
 }
 
 $stmt->close();
 $conn->close();

?>