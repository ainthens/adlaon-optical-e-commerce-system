<?php
      function filterTable($status)
      {
        include('conn.php');
        $sql = "SELECT o.order_id, o.user_id, o.order_date, u.full_name, o.status, u.email, SUM(o.total_amount) AS total_amount_sum FROM orders o JOIN users u ON o.user_id = u.id ";
        if($status !== "All")
        {
            $status = mysqli_real_escape_string($conn, $status);
            $sql   .= "WHERE o.status = '$status' ";
          
        } 
        $sql .= "GROUP BY o.order_id, o.user_id, o.order_date;";
        $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {

                echo '<tr data-status="'.htmlspecialchars($row['status']).'">';
                echo '<td>'.$row['order_id'].'</td>';
                echo '<td>'.$row['full_name'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                echo '<td>'.$row['total_amount_sum'].'</td>';
                echo '<td>'.$row['status'].'</td>';
                echo '<td>'.$row['order_date'].'</td>';
                echo '<td>';
                echo '<button class="viewOrdersBtn admin-button" data-order-id="'.$row['order_id'].'">';
                echo    'View Order';
                echo  '</button>';
                echo '</td>'; // <-- Corrected
                echo '</tr>'; // <-- Corrected
                
                
              }
            }
      }
        

      ?>