document.querySelectorAll(".delete-btn").forEach(function(button){
    button.addEventListener("click",function(e){
        e.preventDefault();
        let productId = this.getAttribute('product-id');
        let ok = confirm("Are you sure you want to delete product id: "+productId+"?");

        if(ok)
        {
            fetch("delete_eyewear.php", {
            method: "POST",
            headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
            body: "productId=" + encodeURIComponent(productId)

        })
        .then(res => res.text())
        .then(response => {
            
            location.reload();
            
        })
        .catch(err => {
            alert("Something went wrong: " + err);
        });
        }
        else{

        }
    })
})


