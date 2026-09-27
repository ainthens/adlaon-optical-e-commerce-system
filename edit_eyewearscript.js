let productId = 0;
let imagePath;
document.querySelectorAll(".edit-product").forEach(function (button) {
    button.addEventListener("click", function (e) {
        e.preventDefault();
        

        const modal = document.getElementById("editEyewearModal");
        modal.style.display = "block";

        document.querySelector("#eyewearName2").value = this.dataset.name;
        document.querySelector("#category2").value = this.dataset.category;
        document.querySelector("#price2").value = this.dataset.price;
        document.querySelector("#stock2").value = this.dataset.stock;
        productId = this.dataset.id;

        const imgElement = document.querySelector("#editEyewearImage"); // only once
        const imgPath = "uploads/" + this.dataset.image;
        imgElement.src = imgPath;

        console.log("Image path:", imgPath);

        document.querySelector("#currentImagePath").value = imgPath;

    });
})

document.querySelector("#edit-close").addEventListener("click", function (e) {
    e.preventDefault();

    const modal = document.getElementById("editEyewearModal");
    modal.style.display = "none";
});

document.querySelector("#edit-new-eyewear").addEventListener("click", function (e) {
    e.preventDefault();
    const form = document.querySelector("#editEyewearForm");
    const formData = new FormData(form);

    formData.append("product_id", productId);
    formData.append("product_img", imagePath);
    

    fetch("edit_eyewear.php", {
        method: "POST",
        body: formData,

    })
        .then(res => res.text())
        .then(response => {
           
            form.reset();
            location.reload();
        })
        .catch(err => {
            alert("Something went wrong: " + err);
        });
})