<?php
include('conn.php');

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);

    // Query to get details for the order_id
    $sql = "SELECT o.order_id, o.product_title, o.quantity, o.product_price, o.status, u.address FROM orders o JOIN users u on o.user_id = u.id WHERE o.order_id = $order_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $first = true;
        $status = "";
        $total_price = 0;
        $shipping_fee = 149.00;
        $first2 = true;

        echo "<div class='ao-order-details'>";

        // Order ID row
        echo "<div class='ao-detail-row'>";
        echo "<span class='ao-detail-label'>Order ID:</span>";
        echo "<span class='ao-detail-value'>#" . htmlspecialchars($order_id) . "</span>";
        echo "</div>";
        echo "<div class='ao-detail-row'>";
        while ($row = mysqli_fetch_assoc($result)) {
        if ($first) {
            $first = false;

            $address = htmlspecialchars($row['address']);
        }
    }
        echo "<span class='ao-detail-label'>Address:</span>";
        echo "<span class='ao-detail-value'>" . htmlspecialchars($address) . "</span>";
        echo "</div>";

        $result = mysqli_query($conn,$sql);
        // Product details and total calculation
        while ($row = mysqli_fetch_assoc($result)) {
            if ($first2) {
                $status = $row['status'];
                
                $first2 = false;
            }
            $line_total = $row['product_price'] * $row['quantity'];
            $total_price += $line_total;

            echo "<div class='ao-detail-row'>";
            echo "<span class='ao-detail-label'>" . htmlspecialchars($row['product_title']) . " <span style='color:#888;font-weight:400;'>(x" . $row['quantity'] . ")</span></span>";
            echo "<span class='ao-detail-value'>₱ " . number_format($line_total, 2) . "</span>";
            echo "</div>";
        }

        // Total row
        echo "<div class='ao-total-row'>";
        echo "<span>Total:</span>";
        echo "<span>₱ " . number_format($total_price, 2) . "</span>";
        echo "</div>";

        echo "</div>";

        // Action buttons
        echo "<div class='ao-btn-container'>";
        if ($status == "Pending") {
            echo '<button class="ao-btn ao-btn-decline decline-order" data-order-id="' . $order_id . '">Decline</button>';
            echo '<button class="ao-btn ao-btn-confirm accept-order" data-order-id="' . $order_id . '">Confirm</button>';
        } else if ($status == "Accepted") {
            echo '<button class="ao-btn ao-btn-confirm ship-order" data-order-id="' . $order_id . '">Ship Order</button>';
        }
        echo "</div>";
    } else {
        echo "<p class='ao-no-data'>No order details found.</p>";
    }
} else {
    echo "<p class='ao-no-data'>Invalid order ID.</p>";
}
?>