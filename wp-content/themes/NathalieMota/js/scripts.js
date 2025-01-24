document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");
});

document.addEventListener("DOMContentLoaded", function () {
    let modal = document.getElementById("contact-modal");
    let close = document.querySelector(".close");

    document.getElementById("open-modal").addEventListener("click", function () {
        modal.style.display = "block";
    });

    close.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
