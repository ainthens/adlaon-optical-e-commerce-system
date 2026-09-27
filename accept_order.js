document.querySelector(".order-container").addEventListener("click",function(e){
    if (e.target.classList.contains('accept-order')) {
    e.preventDefault();
    let choice = confirm("Are you sure you want to accept this order?");
    if (choice)
    {
        const orderId = e.target.getAttribute("data-order-id");
        console.log("Order ID to update:", orderId);
        fetch("update_order_status.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "order_id=" + encodeURIComponent(orderId) + "&status=Accepted",
      })
        .then((response) => response.text())
        .then((data) => {
          location.reload(); // You can show success message or update the UI
        })
        .catch((error) => {
          alert("Error updating order.");
          console.error(error);
        });
    } else {
      alert("Cancelled action");
    }
    
  }
})

document.querySelector(".order-container").addEventListener("click",function(e){
    if (e.target.classList.contains('decline-order')) {
    e.preventDefault();
    let choice = confirm("Are you sure you want to decline this order?");
    if (choice)
    {
        const orderId = e.target.getAttribute("data-order-id");
        console.log("Order ID to update:", orderId);
        fetch("update_order_status.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "order_id=" + encodeURIComponent(orderId) + "&status=Declined",
      })
        .then((response) => response.text())
        .then((data) => {
          location.reload(); // You can show success message or update the UI
        })
        .catch((error) => {
          alert("Error updating order.");
          console.error(error);
        });
    } else {
      alert("Cancelled action");
    }
  }
})
document.querySelector(".order-container").addEventListener("click",function(e){
    if (e.target.classList.contains('ship-order')) {
    e.preventDefault();
    let choice = confirm("Are you sure you want to ship this order?");
    if (choice)
    {
        const orderId = e.target.getAttribute("data-order-id");
        console.log("Order ID to update:", orderId);
        fetch("update_order_status.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "order_id=" + encodeURIComponent(orderId) + "&status=Shipped Out",
      })
        .then((response) => response.text())
        .then((data) => {
          location.reload(); // You can show success message or update the UI
        })
        .catch((error) => {
          alert("Error updating order.");
          console.error(error);
        });
    } else {
      alert("Cancelled action");
    }
  }
})