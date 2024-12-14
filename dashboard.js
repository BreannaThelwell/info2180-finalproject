document.addEventListener("DOMContentLoaded", function () {
    const contactTableBody = document.querySelector(".table tbody");

    // Fetch contacts via AJAX
    fetch("dashboard.php?filter=all")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            // Populate table with contact data
            contactTableBody.innerHTML = "";
            data.forEach((contact) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${contact.title} ${contact.firstname} ${contact.lastname}</td>
                    <td>${contact.email}</td>
                    <td>${contact.company}</td>
                    <td>
                        <span class="badge ${contact.type.toLowerCase().replace(" ", "-")}">
                            ${contact.type.toUpperCase()}
                        </span>
                    </td>
                    <td><a href="view_contact.php?id=${contact.id}">View</a></td>
                `;
                contactTableBody.appendChild(row);
            });
        })
        .catch((error) => {
            console.error("Failed to load contacts:", error);
            contactTableBody.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align: center; color: red;">Failed to load contacts. Please try again.</td>
                </tr>
            `;
        });
});
