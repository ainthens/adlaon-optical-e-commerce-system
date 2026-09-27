document.querySelectorAll("#received-btn").forEach(button =>{
    button.addEventListener("click", function(e){
        e.preventDefault();
        const orderId = button.getAttribute('data-order-id');
        console.log("order Id: "+orderId);
        fetch("update_order_status.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "order_id=" + encodeURIComponent(orderId) + "&status=Received",
      })
        .then((response) => response.text())
        .then((data) => {
          location.reload(); 
        })
        .catch((error) => {
          alert("Error updating order.");
          console.error(error);
        });
    })
})
document.querySelectorAll("#cancel-btn").forEach(button =>{
    button.addEventListener("click", function(e){
        e.preventDefault();
        const orderId = button.getAttribute('data-order-id');
        console.log("order Id: "+orderId);
        fetch("update_order_status.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "order_id=" + encodeURIComponent(orderId) + "&status=Cancelled",
      })
        .then((response) => response.text())
        .then((data) => {
          location.reload(); 
        })
        .catch((error) => {
          alert("Error updating order.");
          console.error(error);
        });
    })
})