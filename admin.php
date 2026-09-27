<?php
  session_start();
  if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Adlaon Optical - Admin</title>
  <link rel="stylesheet" href="adminstyles.css">
  <link rel="icon" type="image/png" href="favicon.png">
</head>
<body>
  <div class="sidebar">
    <div>
      <div class="logo">
        <img src="logos/AdlaonLogo-nobg.svg" alt="Logo" style="width: 225px;" />
      </div>
      <div class="nav-links">
        <a class="nav-link active" href="#" data-view="dashboard">
          <img src="icons/dashboard.svg" alt="Dashboard Icon" />
          Dashboard
        </a>
        <a class="nav-link" href="#" data-view="users">
          <img src="icons/users.svg" alt="User Icon" />
          User Management
        </a>
        <a class="nav-link" href="#" data-view="products">
            <img src="icons/eyewear.svg" alt="Eyewearcon" />
            Eyewear Products
        </a>
        <a class="nav-link" href="#" data-view="appointments">
            <img src="icons/appointments.svg" alt="Appointments Icon" />
            Appointments
        </a>
        <a class="nav-link" href="#" data-view="orders">
            <img src="icons/orders_icon.svg" alt="Orders Icon" />
            Orders
        </a>
      </div>
    </div>
    <div class="bottom-links">
      
      <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');">
  <img src="icons/logout.svg">Log out
</a>

    </div>
  </div>

  <div class="main">
    <div id="dashboard" class="view active dashboard">
      <h2>Dashboard Overview</h2>
      <p>Welcome back, Admin!</p>
      <div class="cards">
        <div class="card">
          <h3>Total Appointments</h3>
          <?php
          include ('conn.php');
            $sql = "SELECT COUNT(*) AS total FROM appointments";
            $result = $conn->query($sql);
            if ($result) {
                $row = $result->fetch_assoc();
                echo '<div class="value">' . $row['total'] . '</div>';
            } else {
                echo "Error: " . $conn->error;
            }           
          ?>
          <div class="sub">Appointments</div>
        </div>
        <div class="card">
          <h3>Pending appointments</h3>
          <?php
          include ('conn.php');
            $sql = "SELECT COUNT(*) AS total FROM appointments WHERE status = 'Pending'";
            $result = $conn->query($sql);
            if ($result) {
                $row = $result->fetch_assoc();
                echo '<div class="value">' . $row['total'] . '</div>';
            } else {
                echo "Error: " . $conn->error;
            }           
          ?>
          <div class="sub">This month</div>
        </div>
        <div class="card">
          <h3>Total Sales</h3>
          <?php
            include('conn.php');
            $sql = "SELECT SUM(total_amount) as sales FROM orders WHERE status = 'Received'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) == 1)
            {
              while($row = mysqli_fetch_assoc($result))
              {
                echo '<div class = "value">₱ '.$row['sales'].'</div>';
              }
            }
            else{
              echo '<div class = "value">₱ 0.00</div>';
            }
          ?>
          
        </div>
        <div class="card">
          <h3>Total Eyewear Available</h3>
          <?php
          include ('conn.php');
            $sql = "SELECT COUNT(*) AS total FROM products";
            $result = $conn->query($sql);
            if ($result) {
                $row = $result->fetch_assoc();
                echo '<div class="value">' . $row['total'] . '</div>';
            } else {
                echo "Error: " . $conn->error;
            }           
          ?>
          <div class="sub">Eyewear Products</div>
        </div>
      </div>
      
      <div class="appointment">
        <h3>Today's Appointments</h3>
        <table class="appointments-table">
          <thead>
            <tr>
              <th>Appointment ID</th>
              <th>Time</th>
              <th>Patient Name</th>
              <th>Email</th>
              <th>Service</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include('conn.php');
            $sql = 'SELECT * FROM appointments WHERE appoint_date = CURDATE();';
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) > 0)
            while($row = mysqli_fetch_assoc($result))
            {
              $status =strtolower($row['status']);

              echo '<tr><td>'.$row['appointment_id'].'</td>
                    <td>'.$row['appoint_time'].'</td>
                    <td>'.$row['patient_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['services_selected'].'</td>
                    <td><span class ="status '.$status.'">'.$row['status'].'</span></td>
                    <td>
                      <select class="status-select" onchange="updateAppointmentStatus(this, '.$row['appointment_id'].')">
                        <option value="pending"' . ($status == 'pending'   ? 'selected' : '') . '>Pending</option>
                        <option value="completed"' . ($status == 'completed'   ? 'selected' : '') . '>Completed</option>
                        <option value="cancelled"' . ($status == 'cancelled'   ? 'selected' : '') . '>Cancelled</option>
                      </select>
                    </td></tr>';
            }
            ?>
            

          </tbody>
        </table>
      </div>
      
      
    </div>

    <div id="users" class="view">
    <?php
        include('conn.php');
        $deleted = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
            $delete_id = intval($_POST['delete_user_id']);
            $delete_sql = "DELETE FROM users WHERE id = $delete_id";
            if (mysqli_query($conn, $delete_sql)) {
                $deleted = true;
            }
        }

        $sql = "SELECT id, full_name, email, phone_number, role FROM users";
        $result = mysqli_query($conn, $sql);
    ?>

    <h2>User Management</h2>
    <table class="user-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone_number']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete user <?= htmlspecialchars($row['full_name']) ?>?');">
                      <input type="hidden" name="delete_user_id" value="<?= htmlspecialchars($row['id']) ?>">
                      <button type="submit" style="font-weight: bold; background-color: red; color: white; border: none; padding: 3px 7px; font-size: 12px; cursor: pointer; border-radius: 3px;">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php else: ?>
            <tr><td colspan="6">No users found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($deleted): ?>
    <script>
        alert('User Deleted Successfully');
    </script>
    <?php endif; ?>
</div>
<div id="appointments" class="view">
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
              <th>Actions</th>
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
                    $status = strtolower($row['status']);
                    echo "<tr>
                <td>{$row['appointment_id']}</td>
                <td>{$row['appoint_date']}</td>
                <td>{$row['appoint_time']}</td>
                <td>{$row['patient_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['services_selected']}</td>
                <td><span class='status {$statusClass}'>".strtoupper($row['status'])."</span></td>
                <td>
                    <select class='status-select' onchange='updateAppointmentStatus(this, {$row['appointment_id']})'>
                        <option value='pending' ".($status === 'pending'   ? 'selected' : '').">Pending</option>
                        <option value='completed' ".($status == 'completed' ? 'selected' : '').">Completed</option>
                        <option value='cancelled' ".($status == 'cancelled' ? 'selected' : '').">Cancelled</option>
                    </select>
              </td>
              </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No appointments for today.</td></tr>";
            }
              ?>
          </tbody>
        </table>
        <a href="print_appointments.php" target="_blank">
        <br>
      <div style="display: flex; justify-content: flex-end; width: 100%;">
        <button class="print-btn">
    PRINT
        </button>
    </div>
</a>

    </div>
<div id="orders" class="view">
  <h2>Customer Orders</h2>
  <br>
  <!-- Sorting Buttons -->
  
  <div class="order-sorting-buttons">
    <button class="order-sort-btn active" id="show-all-btn" data-status="Show All">
      <img src="icons/show-all.svg" alt="Confirmed Icon">
      Show All
    </button>
    <button class="order-sort-btn" id="pending-btn" data-status="Pending">
      <img src="icons/pending.svg" alt="Confirmed Icon">
      Pending
    </button>
    <button class="order-sort-btn" id="accept-btn" data-status="Accepted">
      <img src="icons/confirmed.svg" alt="Confirmed Icon">
      Accepted
    </button>
    <button class="order-sort-btn" id="declined-btn" data-status="Declined">
      <img src="icons/declined.svg" alt="Declined Icon">
      Declined
    </button>
    <button class="order-sort-btn" id="shipped-out-btn" data-status="Shipped Out">
      <img src="icons/shipped.svg" alt="Shipped Out Icon">
      Shipped out
    </button>
    <button class="order-sort-btn" id="received-btn" data-status="Received">
      <img src="icons/received.svg" alt="Delivered Icon">
      Received
    </button>
    <button class="order-sort-btn" id="cancelled-btn" data-status="Cancelled">
      <img src="icons/cancelled.svg" alt="Delivered Icon">
      Cancelled
    </button>
</div>
  <div class="table-container"> 
    <table class="orders-table">
      <thead>
      <tr>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Email</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Date Ordered</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="ordersTableBody">
      <?php
        include('conn.php');
        $sql = "SELECT o.order_id, o.user_id, o.order_date, u.full_name, o.status, u.email, SUM(o.total_amount) AS total_amount_sum FROM orders o JOIN users u ON o.user_id = u.id ";
        
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
                echo '</td>'; 
                echo '</tr>'; 
                
                
              }
            }
      
        

      ?>
    </tbody>
    </table>
  </div>
</div>

    <div id="products" class="view">
      <h2>Eyewear Products</h2>
      <div class="admin-product-cards">
        <div class="admin-product-card">
          <img src="icons/add-eyewear.svg" alt="Add Icon" class="admin-product-card-icon" />
          <h3>Add an Eyewear</h3>
          <button id="addEyewearBtn" class="admin-button">Add Eyewear</button>
        </div>


      </div>
      
    </div>

    <!-- Modal for Adding Eyewear -->
    <div id="addEyewearModal" class="add-eyewear-modal">
      <div class="add-eyewear-modal-content">
        <span class="admin-close">&times;</span>
        <h3>Add New Eyewear</h3>
        <form id="addEyewearForm" action="add_eyewear_handler.php" method="POST" enctype="multipart/form-data">
          <label for="eyewearImage">Upload Eyewear Image:</label>
          <input type="file" id="eyewearImage" name="eyewearImage" accept="image/*" required />

          <label for="eyewearName">Enter Eyewear Name:</label>
          <input type="text" id="eyewearName" name="eyewearName" required />

          <label for="category">Enter Category:</label>
          <select id="category" name="category" required>
            <option value="eyeglasses">Eyeglasses</option>
            <option value="sunglasses">Sunglasses</option>
            <option value="sports">Sports</option>
            <option value="kids">Kids</option>
            <option value="reading">Reading</option>
          </select>

          <label for="price">Enter Price:</label>
          <input type="number" id="price" name="price" step="0.01" required />

          <label for="stock">Enter Stock Number:</label>
          <input type="number" id="stock" name="stock" min="0" required />

          <button type="submit" class="admin-button" id="add-new-eyewear">Submit</button>
        </form>
      </div>
    </div>
    <!-- modal for viewing orders -->
    <div id="viewOrdersModal" class="admin-modal">
      <div class="admin-modal-content">
        <span class="admin-close" id="close-orders">&times;</span>
        <h3>Orders</h3>
        <div class="order-container">
            <?php include 'fetch_order_details.php'; ?>
        </div>
      </div>
    </div>
    <div id="editEyewearModal" class="admin-modal2">
      <div class="admin-modal-content">
        <span class="admin-close" id = "edit-close">&times;</span>
        <h3>Edit New Eyewear</h3>

        <form id="editEyewearForm" action="add_eyewear_handler.php" method="POST" enctype="multipart/form-data">
        <center>
        <div class="img-container">
          <img id="editEyewearImage" src="" alt="Eyewear Image" />
        </div>
        </center>
        <label for="eyewearImage">Change Image (optional):</label>
        <input type="file" id="eyewearImage" name="eyewearImage" accept="image/*" />
        <input type="hidden" id="currentImagePath" name="currentImagePath" value = ""/>
        

          <label for="eyewearName">Enter Eyewear Name:</label>
          <input type="text" id="eyewearName2" name="eyewearName" required />

          <label for="category">Enter Category:</label>
          <select id="category2" name="category" required>
            <option value="eyeglasses">Eyeglasses</option>
            <option value="sunglasses">Sunglasses</option>
            <option value="sports">Sports</option>
            <option value="kids">Kids</option>
            <option value="reading">Reading</option>
          </select>

          <label for="price">Enter Price:</label>
          <input type="number" id="price2" name="price" step="0.01" required />

          <label for="stock">Enter Stock Number:</label>
          <input type="number" id="stock2" name="stock" min="0" required />

          <button type="submit" class="admin-button" id = "edit-new-eyewear">Submit</button>
        </form>
      </div>
    </div>
    <div id="products" class="view">
      <br>
      <div class="products-grid">
        <?php
          include('conn.php');
          $sql = "SELECT id, title, category, price, image, stocks FROM products";
          $result = mysqli_query($conn, $sql);
          if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
        // Prepare variables
        $category = htmlspecialchars($row['category']);
        $title = htmlspecialchars($row['title']);
        $currentPrice = $row['price'];
        $image = htmlspecialchars($row['image']); // image filename
        $stocks = intval($row['stocks']); // fix here
        $productId = $row['id'];

        // Start outputting HTML card
        echo '<div class="product-card" data-category="' . $category . '">';
        echo '  <div class="product-image">';
        //echo '    <span class="product-badge"></span>';
        echo '    <img src="' . $image . '" alt="glasses">';
        echo '  </div>';
        echo '  <div class="product-details">';
        echo '    <div class="product-category">' . $category . '</div>';
        echo '    <h3 class="product-title">' . $title . '</h3>';
        echo '    <div class="product-price">';
        echo '      <span class="current-price">₱' . number_format($currentPrice, 2) . '</span>';
        echo '    </div>';
        echo '    <div class="product-stock">';
        echo '      <strong>Product ID:</strong> ' . $productId . '<br>';
        echo '      <strong>Stock:</strong> ' . $stocks;
        echo '    </div>';
        echo '    <div class="product-actions">';
        
        // Add all data attributes to the button
        echo '      <button class="edit-product" ';
        echo '        data-id="' . $productId . '" ';
        echo '        data-name="' . $title . '" ';
        echo '        data-category="' . $category . '" ';
        echo '        data-price="' . $currentPrice . '" ';
        echo '        data-stock="' . $stocks . '" ';
        echo '        data-image="' . basename($image) . '">'; // ✅ move this inside
        echo '        <img src="edit-icon.svg" alt="Edit Icon"> Edit';
        echo '      </button>';

        echo '      <button class="delete-btn" product-id="' . $productId . '">Delete</button>';

        echo '    </div>'; // product-actions
        echo '  </div>';   // product-details
        echo '</div>';
    }
} else {
    echo '<p>No products found.</p>';
}

        ?>

            </div>
        </div>
    </div>

    <div id="addEyewearModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Add New Eyewear</h3>
        <form id="addEyewearForm" action="add_eyewear_handler.php" method="POST">
          <label for="eyewearName">Enter Eyewear Name:</label>
          <input type="text" id="eyewearName" name="eyewearName" required />

          <label for="category">Enter Category:</label>
          <select id="category" name="category" required>
            <option value="eyeglasses">Eyeglasses</option>
            <option value="sunglasses">Sunglasses</option>
            <option value="sports">Sports</option>
            <option value="kids">Kids</option>
            <option value="reading">Reading</option>
          </select>

          <label for="price">Enter Price:</label>
          <input type="number" id="price" name="price" step="0.01" required />

          <button type="submit" class="button">Submit</button>
        </form>
      </div>
    </div>

    <div id="viewOrdersModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Orders</h3>
        
      </div>
    </div>

    

            <!-- orde view knigsgagagsdgasdjhsdgasd -->
             <!-- yung sa eyewear stocks logic aayusin mo pa  -->
  


  <script src = "add_eyewearscript.js"></script>
  <script src = "delete_eyewearscript.js"></script>
  <script src = "edit_eyewearscript.js"></script>
  <script src = "accept_order.js"></script>
  <script src="filter_status.js"></script>

  <script>
              function updateAppointmentStatus(selectEl, appointmentId) {
              const newStatus = selectEl.value;

              fetch('update_appointment_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `appointment_id=${encodeURIComponent(appointmentId)}&status=${encodeURIComponent(newStatus)}`
              })
              .then(r => r.text())
              .then(msg => {
                  // optional: toast / alert
                  console.log(msg);
                  // also update the coloured badge in the same row
                  location.reload();
              })
              .catch(err => alert('Error: ' + err));
            }
            </script>
  

  <script>
  // Sidebar Navigation
  const navLinks = document.querySelectorAll('.nav-link');
  const views = document.querySelectorAll('.view');

  navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      // Update active class on sidebar
      navLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      // Show the selected view
      const targetView = this.getAttribute('data-view');
      views.forEach(view => {
        view.classList.remove('active');
        if (view.id === targetView) {
          view.classList.add('active');
        }
      });
    });
  });

  // Modal Functionality
  const modal = document.getElementById("addEyewearModal");
  const modal2 = document.getElementById("viewOrdersModal");
  const btn = document.getElementById("addEyewearBtn");
  const btn2 = document.getElementById("viewOrdersBtn");
  const span = document.querySelector(".admin-close");
  const span2 = document.querySelector("#close-orders");

  // Open the modal when the button is clicked
  btn.onclick = function () {
    modal.style.display = "block";
  };

 document.querySelectorAll('.viewOrdersBtn').forEach(button => {
  button.addEventListener('click', () => {
    const orderId = button.getAttribute('data-order-id'); // Get order id from button
    

    modal2.style.display = "block";

    fetch('fetch_order_details.php?order_id=' + orderId)
      .then(response => response.text())
      .then(data => {
        document.querySelector('.order-container').innerHTML = data;
      })
      .catch(err => {
        document.querySelector('.order-container').innerHTML = 'Error loading order details.';
      });
  });
});

  // Close the modal when the "x" is clicked
  span.onclick = function () {
    modal.style.display = "none";
  };
  span2.onclick = function () {
    modal2.style.display = "none";
  };

  // Close the modal when clicking outside of it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
</script>
<script>
// Add this at the start of your script
document.addEventListener('DOMContentLoaded', function() {
    const viewOrdersModal = document.getElementById('viewOrdersModal');
    if (viewOrdersModal) {
        viewOrdersModal.style.display = 'none';
    }
});

// Update your existing modal open/close code
document.querySelectorAll('.viewOrdersBtn').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-order-id');
        // Your existing AJAX call
        fetch(`fetch_order_details.php?order_id=${orderId}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('#viewOrdersModal .order-container').innerHTML = data;
                document.getElementById('viewOrdersModal').style.display = 'flex';
            });
    });
});

// Close button
document.querySelector('#close-orders').addEventListener('click', function() {
    document.getElementById('viewOrdersModal').style.display = 'none';
});
</script>
<script>
        const currentUserId = <?php echo json_encode($userId); ?>;
        const isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
</script>
<script>
document.querySelectorAll('.order-sort-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.order-sort-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    
  });
});
</script>
  
</body>
</html>
