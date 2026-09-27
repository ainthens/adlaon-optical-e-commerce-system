<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Appointments Admin</title>
    <link rel="stylesheet" href="adminstyles.css" />
    <script>
      // Run this when the page finishes loading
      window.onload = function() {
          window.print();
      };
    </script>
</head>
<body>
      <h2>Appointments</h2>
      <table class="appointments-table">
          <thead>
            <tr>
              <th>Appointment ID</th>
              <th>Date</th>
              <th>Time</th>
              <th>Patient Name</th>
              <th>Email</th>
              <th>Service</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('conn.php');
            $sql = "select appointment_id, appoint_date, appoint_time, patient_name, email, services_selected, status FROM appointments";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result)) {
                    $statusClass = strtolower($row["status"]);
                    echo "<tr>
                <td>{$row['appointment_id']}</td>
                <td>{$row['appoint_date']}</td>
                <td>{$row['appoint_time']}</td>
                <td>{$row['patient_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['services_selected']}</td>
                <td><span class='status {$statusClass}'>".strtoupper($row['status'])."</span></td>
              </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No appointments for today.</td></tr>";
            }
              ?>
          </tbody>
          
        </table>

</body>
</html>
