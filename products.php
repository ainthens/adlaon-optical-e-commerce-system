<?php
if (isset($_GET['category'])){
    $category = ($_GET['category']);
                    include('conn.php');
                    $sql = "SELECT id, title, category, price, image, stocks, times_bought FROM products";
                    if($category != "all"){
                        $sql .= " WHERE category = '$category'";
                    }
                    
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
                        $times_bought = $row['times_bought'];

                        // Start outputting HTML card
                        echo '<div class="product-card" data-category="' . $category . '">';
                        echo '  <div class="product-image">';
                        if($times_bought > 25)
                        {
                            echo '    <span class="product-badge">Best Seller</span>';
                        }
                        //echo '    <span class="product-badge">New</span>';
                        echo '    <img src="' . $image . '" alt="glasses">';
                        echo '  </div>';
                        echo '  <div class="product-details">';
                        echo '    <div class="product-category">' . $category . '</div>';
                        echo '    <h3 class="product-title">' . $title . '</h3>';
                        echo '    <div class="product-price">';
                        echo '      <span class="current-price">₱' . number_format($currentPrice, 2) . '</span>';
                        echo '    </div>';
                        echo '    <div class="product-stock">';
                        echo '<strong style="display: inline;">Product ID:</strong> <p class = "productId", style="display: inline; margin-left: 5px;">' . $productId . '</p>';

                        echo '<p id="stockNum"><strong>Stock:</strong> <span class="stockValue">' . $stocks . '</span></p>';
                        echo '    </div>';
                        echo '    <div class="product-actions">';
                        
                        // Add all data attributes to the button
                        echo '      <button class="add-to-cart" ';
                        echo '        <img src="edit-icon.svg" alt="Edit Icon"> Add to Cart';
                        echo '      </button>';

                        //echo '      <button class="view-details" product-id="' . $productId . '">Details</button>';

                        echo '    </div>'; // product-actions
                        echo '  </div>';   // product-details
                        echo '</div>';
                    }
                } else {
                    echo '<p>No products found.</p>';
                }
            }
                ?>