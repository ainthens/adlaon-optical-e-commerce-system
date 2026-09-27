document.addEventListener('DOMContentLoaded', () => {
    recalculateCartTotal();

  const cartCountEl = document.querySelector(".cart-count");
  const cartItemsEl = document.querySelector(".cart-items");
  const cartTotalEl = document.querySelector("#cart-total-amount");
  let total = 0;
  let cartCount = 0;
  
  
  const userName = "<?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : ''; ?>";
  if(isLoggedIn){
  let cartCount = document.querySelector(".cart-count").textContent;
  let total = 0;
  }
  cartItemsEl.querySelectorAll(".plus-item").forEach(button => {
  button.addEventListener("click", function (e) {
    e.preventDefault();

    const cartItem = e.target.closest(".cart-item");
    const cartControl = e.target.closest(".cart-controls");
    const quantityEl = cartControl.querySelector(".item-quantity");

    let quantity = parseInt(quantityEl.textContent);
    quantity++;

    quantityEl.textContent = quantity;

    const priceEl = cartItem.querySelector(".cart-item-price");
    const basePrice = parseFloat(priceEl.getAttribute("data-base-price"));
    const finalTotal = basePrice * quantity;

    //priceEl.textContent = `₱${finalTotal.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

    recalculateCartTotal();

    // Get product id from data attribute, NOT title
    const productId = cartItem.getAttribute("data-product-id");

    updateCartItemInDatabase(productId, quantity);
    
  });
});
cartItemsEl.querySelectorAll(".minus-item").forEach(button => {
  button.addEventListener("click", function (e) {
    e.preventDefault();

    const cartItem = e.target.closest(".cart-item");
    const cartControl = e.target.closest(".cart-controls");
    const quantityEl = cartControl.querySelector(".item-quantity");

    let quantity = parseInt(quantityEl.textContent);
    quantity--;

    if (quantity <= 0) {
      // Remove item from cart UI
      cartItemsEl.removeChild(cartItem);

      // Optionally update cart count (if you have a cartCount variable)
      // cartCount--;
      // cartCountEl.textContent = cartCount;

      recalculateCartTotal();

      const productId = cartItem.getAttribute("data-product-id");
      removeFromCartDatabase(productId);
    } else {
      quantityEl.textContent = quantity;

      const priceEl = cartItem.querySelector(".cart-item-price");
      const basePrice = parseFloat(priceEl.getAttribute("data-base-price"));
      // Keep priceEl showing base price (if you want), or update it here:
      // priceEl.textContent = `₱${(basePrice * quantity).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

      recalculateCartTotal();

      const productId = cartItem.getAttribute("data-product-id");
      updateCartItemInDatabase(productId, quantity);
    }
  });
});
cartItemsEl.querySelectorAll(".remove-item").forEach(button => {
  button.addEventListener("click", function(e) {
    e.preventDefault();

    const cartItem = e.target.closest(".cart-item");
    if (!cartItem) return;

    const priceEl = cartItem.querySelector(".cart-item-price");
    const basePrice = parseFloat(priceEl.getAttribute("data-base-price"));
    const quantity = parseInt(cartItem.querySelector(".item-quantity").textContent);
    const price = basePrice * quantity;

    // Remove item from DOM
    cartItemsEl.removeChild(cartItem);

    // Update cart count
    //cartCount--;
    //cartCountEl.textContent = cartCount;

    // Update total
    recalculateCartTotal();

    // Update database (use product ID)
    const productId = cartItem.getAttribute("data-product-id");
    removeFromCartDatabase(productId);
  });
});
  // Add to cart button function (UI)
  document.querySelector(".products-grid").addEventListener('click', function(e){
    const button = e.target.closest('.add-to-cart');
    if(!button) return;
    e.preventDefault();
          
    if (!isLoggedIn) {
        alert("You need to log in first.");
        return location.href = 'login.php';
    } else {

          const productCard = button.closest(".product-card");
          const stockText = productCard.querySelector('.stockValue').textContent;
          const stockNumber = parseInt(stockText);
         
          if(stockNumber <= 0)
          {
            alert("There is no stock for this item");
          }
          else
          {
          const title = productCard.querySelector(".product-title").textContent;
          const priceText = productCard.querySelector(".current-price").textContent;
          const imageSrc = productCard.querySelector("img").getAttribute("src");
          const product_id = parseInt(productCard.querySelector(".productId").textContent);

            
          const price = parseFloat(priceText.slice(1).replace(",", ""));
          const existingCartItem = document.querySelector(`.cart-item[data-product-id="${product_id}"]`);

            if (existingCartItem) {
            // If it exists, just increase the quantity by 1
            const quantityEl = existingCartItem.querySelector(".item-quantity");
            let quantity = parseInt(quantityEl.textContent);
            quantity++;

            quantityEl.textContent = quantity;

            // Update cart total in UI
            total += price;
            cartTotalEl.textContent = `₱${total.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

            // Update quantity in database
            updateCartItemInDatabase(product_id, quantity);
            recalculateCartTotal();

            } else {
          alert('Product added to cart!');
          const cartItem = document.createElement("div");
          
          //cartCount++;
          total += price;

         // cartCountEl.textContent = cartCount;
          cartTotalEl.textContent = `₱${total.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

          addToCartDatabase(title, price,product_id);
            }
          

          // Remove from cart button function (UI)
          

          // Increment product quantity (UI)
          

          // Decrement product quantity (UI)
          
        }
        }
  });
  /*document.querySelectorAll(".add-to-cart").forEach(function(button) {
      button.addEventListener("click", function(e) {
          e.preventDefault();
          
    if (!isLoggedIn) {
        alert("You need to log in first.");
        return location.href = 'login.php';
    } else {

          const productCard = this.closest(".product-card");
          const stockText = productCard.querySelector('.stockValue').textContent;
          const stockNumber = parseInt(stockText);
          alert(stockNumber);
          if(stockNumber <= 0)
          {
            alert("There is no stock for this item");
          }
          else
          {
          const title = productCard.querySelector(".product-title").textContent;
          const priceText = productCard.querySelector(".current-price").textContent;
          const imageSrc = productCard.querySelector("img").getAttribute("src");
          const product_id = parseInt(productCard.querySelector(".productId").textContent);

            
          const price = parseFloat(priceText.slice(1).replace(",", ""));
          const existingCartItem = document.querySelector(`.cart-item[data-product-id="${product_id}"]`);

            if (existingCartItem) {
            // If it exists, just increase the quantity by 1
            const quantityEl = existingCartItem.querySelector(".item-quantity");
            let quantity = parseInt(quantityEl.textContent);
            quantity++;

            quantityEl.textContent = quantity;

            // Update cart total in UI
            total += price;
            cartTotalEl.textContent = `₱${total.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

            // Update quantity in database
            updateCartItemInDatabase(product_id, quantity);
            recalculateCartTotal();

            } else {
          alert('Product added to cart!');
          const cartItem = document.createElement("div");
          
          //cartCount++;
          total += price;

         // cartCountEl.textContent = cartCount;
          cartTotalEl.textContent = `₱${total.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

          addToCartDatabase(title, price,product_id);
            }
          

          // Remove from cart button function (UI)
          

          // Increment product quantity (UI)
          

          // Decrement product quantity (UI)
          
        }
        }
    });
});*/

  // Checkout function (UI)
  document.querySelector(".checkout-btn").addEventListener("click", function(e) {
      e.preventDefault();
      let total_price = document.getElementById("cart-total-amount").textContent;
      
      if(total_price == "₱0.00")
      {
        alert("Cannot proceed to checkout with no items");
      }
      else{
      const cartItems = document.querySelectorAll(".cart-item");
      cartItems.forEach(function(item) {
          const title = item.querySelector(".cart-item-title").textContent;
          const price = parseFloat(item.querySelector(".cart-item-price").getAttribute("data-base-price"));
          const quantity = parseInt(item.querySelector(".item-quantity").textContent);
          const xhr = new XMLHttpRequest();
          xhr.open("POST", "cart_action.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  console.log(xhr.responseText);
                  item.remove();
                  updateCartTotal();
              }
          };
          xhr.send(
              `action=checkout` +
              `&user_id=${currentUserId}` +
              `&product_title=${encodeURIComponent(title)}` +
              `&product_price=${price}` +
              `&quantity=${quantity}`
          );
      });

      const cartCountEl = document.querySelector(".cart-count");
      const cartTotalEl = document.querySelector("#cart-total-amount");
      cartCountEl.textContent = "0";
      cartTotalEl.textContent = "₱0.00";
      
      alert("Checkout successful! Enjoy your product.");
    }
  });

    // Check muna kung logged in bago ma-add sa cart yung product (UI)
//     document.querySelectorAll('.add-to-cart').forEach(function(button){
//     button.addEventListener("click", function(e){
//         e.preventDefault();
        
//         }
//     })
// })

  // Function for quantity adjustments (UI)
  function recalculateCartTotal() {
  let newTotal = 0;

  document.querySelectorAll(".cart-item").forEach(function(item) {
    const quantity = parseInt(item.querySelector(".item-quantity").textContent);
    const basePrice = parseFloat(item.querySelector(".cart-item-price").getAttribute("data-base-price"));
    newTotal += basePrice * quantity;
  });

  const cartTotalEl = document.querySelector("#cart-total-amount"); // ✅ define it here
  if (cartTotalEl) {
    cartTotalEl.textContent = `₱${newTotal.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
  }
}


  // Function to update product total (UI)
  function updateCartTotal() {
      let newTotal = 0;
      
      document.querySelectorAll(".cart-item").forEach(function(item) {
          const quantity = parseInt(item.querySelector(".item-quantity").textContent);
          const basePrice = parseFloat(item.querySelector(".cart-item-price").getAttribute("data-base-price"));
          newTotal += basePrice * quantity;
      });

      const cartTotalEl = document.querySelector("#cart-total-amount");
      cartTotalEl.textContent = `₱${newTotal.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
  }
});

  // Add product to database
  function addToCartDatabase(title, price,product_id) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "cart_action.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
              console.log("Item added to cart in the database.");
              location.reload();
          }
      };
      xhr.send(
          `action=add_to_cart` +
          `&user_id=${currentUserId}` +
          `&product_id=${product_id}` +
          `&product_title=${encodeURIComponent(title)}` +
          `&product_price=${price}` +
          `&quantity=1`
      );
      
  }

  // Remove product from database
  function removeFromCartDatabase(product_id) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "cart_action.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
              console.log("Item removed from cart in the database.");
              
          }
      };
      xhr.send(
          `action=remove_from_cart` +
          `&product_id=${encodeURIComponent(product_id)}` +
          `&user_id=${currentUserId}`
      );
  }

// Update product quantity from database
function updateCartItemInDatabase(productId, quantity) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "cart_action.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log("Item quantity updated in the database.");
    }
  };
  xhr.send(
    `action=update_quantity` +
    `&user_id=${currentUserId}` +
    `&product_id=${productId}` +
    `&quantity=${quantity}`
  );
}

  // Cart logo
  document.querySelector(".cart-btn").addEventListener("click", function(e){
      e.preventDefault();
      if(isLoggedIn){
      document.querySelector(".cart-container").classList.toggle("active");
      document.querySelector(".cart-overlay").classList.toggle("active");
   }else{
    alert("You need to log in first.");
        return location.href = 'login.php';
   }
  });

  document.querySelector(".close-cart").addEventListener("click", function(e){
      e.preventDefault();
      document.querySelector(".cart-container").classList.remove("active");
      document.querySelector(".cart-overlay").classList.remove("active");
      location.reload();
  });

// Function for "Welcome, User!"
window.onload = function() {
  if(isLoggedIn){
  if (userName) {
      const firstName = userName.split(" ")[0];
      const welcomeMessage = document.querySelector(".welcome-btn");
      welcomeMessage.textContent = `Welcome, ${firstName}!`;

      document.getElementById("logout-btn").style.display = "block";

      const loginButton = document.querySelector(".login-btn");
      const signupButton = document.querySelector(".signup-btn");
      if (loginButton) loginButton.style.display = "none";
      if (signupButton) signupButton.style.display = "none";
  }
}
};