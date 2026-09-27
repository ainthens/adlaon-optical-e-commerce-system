document.querySelector("#add-new-eyewear").addEventListener("click",function(e){
    e.preventDefault();

    const form = document.querySelector("#addEyewearForm");
    const formData = new FormData(form);
    

    fetch("add_new_eyewear.php", {
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
