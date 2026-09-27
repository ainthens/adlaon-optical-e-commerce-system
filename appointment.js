
let services = [];
document.querySelector(".sched-btn").addEventListener("click", function(e){
    e.preventDefault();

    const fullName = document.querySelector("#fullName").value;
    const email = document.querySelector("#email").value;
    const phone = document.querySelector("#phone").value;
    const date = document.querySelector("#date").value;
    const time = document.querySelector("#timeSlot").value;
    const addInfo = document.querySelector("#notes").value;
    
    let boxes = document.querySelectorAll('[name="services[]"]:checked');
    for (let i = 0; i < boxes.length; i++) 
    {
        services.push(boxes[i].value);
    }
    let servicesTxt = services.join(", ");

    fetch("save_appointment.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `fullName=${encodeURIComponent(fullName)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&date=${date}&time=${time}&services=${encodeURIComponent(servicesTxt)}&notes=${encodeURIComponent(addInfo)}`

    })
    .then(res => res.text())
    .then(response => {

        alert("Appointment Scheduled!");
        
        clearFields();
    })
    .catch(err => {
        alert("Something went wrong: " + err);
    });

    


});

document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.querySelector("#date");

    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');

    const formattedDate = `${yyyy}-${mm}-${dd}`;
    dateInput.min = formattedDate;
});

function clearFields()
{
    const fullName = document.querySelector("#fullName").value = "";
    const email = document.querySelector("#email").value = "";
    const phone = document.querySelector("#phone").value = "";
    const date = document.querySelector("#date").value = "";
    const time = document.querySelector("#timeSlot").value = "";
    const addInfo = document.querySelector("#notes").value = "";
    let boxes = document.querySelectorAll('[name="services[]"]');
    for (let i = 0; i < boxes.length; i++) {
        boxes[i].checked = false;
    }
    services = [];
}