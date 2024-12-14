document.addEventListener("DOMContentLoaded", function () {
    const contactTableBody = document.querySelector(".table tbody");

    // Function to render contacts dynamically
    function renderContacts(data, filterType = "All") {
        contactTableBody.innerHTML = ""; // Clear existing content

        const filteredData = filterType === "All"
            ? data
            : data.filter(contact => contact.type === filterType);

        if (filteredData.length === 0) {
            contactTableBody.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align: center; color: grey;">No contacts found</td>
                </tr>
            `;
            return;
        }

        filteredData.forEach((contact) => {
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
    }

    // Fetch contacts via AJAX
    let contacts = []; // For storing the fetched contacts
    fetch("dashboard.php?filter=all")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            contacts = data; // Save fetched contacts
            renderContacts(contacts); // Render all contacts initially
        })
        .catch((error) => {
            console.error("Failed to load contacts:", error);
            contactTableBody.innerHTML = `
                <tr>
                    <td colspan="5" style="text-align: center; color: red;">Failed to load contacts. Please try again.</td>
                </tr>
            `;
        });

    // Filter functionality
    document.getElementById("filter-all").addEventListener("click", () => renderContacts(contacts, "All"));
    document.getElementById("filter-sales-leads").addEventListener("click", () => renderContacts(contacts, "Sales Leads"));
    document.getElementById("filter-support").addEventListener("click", () => renderContacts(contacts, "Support"));
    document.getElementById("filter-assigned").addEventListener("click", () => renderContacts(contacts, "Assigned to me"));

    // Highlight active filter
    const filterLinks = document.querySelectorAll(".filters a");
    filterLinks.forEach(link => {
        link.addEventListener("click", (event) => {
            filterLinks.forEach(link => link.classList.remove("active")); // Remove active class from all
            event.target.classList.add("active"); // Add active class to the clicked link
        });
    });
});
