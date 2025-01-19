document.addEventListener("DOMContentLoaded", function () {
    console.log("JavaScript Loaded!");

    let modal = document.getElementById("contact-modal");
    let close = document.querySelector(".close");
    let openModalButton = document.getElementById("open-modal");

    if (modal && close && openModalButton) {
        openModalButton.addEventListener("click", function () {
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
    }
});
