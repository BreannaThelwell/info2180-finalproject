document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addContactForm");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(form);

        // Send AJAX request
        fetch("add_contact.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then((data) => {
                alert("Contact added successfully!"); // Show success message
                form.reset(); // Reset the form
            })
            .catch((error) => {
                console.error("There was a problem with the request:", error);
                alert("Failed to add contact. Please try again.");
            });
    });
});
