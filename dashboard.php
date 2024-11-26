//php for dashboard/homscreen

<?php
require_once 'config.php';
require_once 'functions.php';

if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$contacts = get_contacts($filter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM - Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="filters">
            <a href="?filter=all" class="<?php echo $filter == 'all' ? 'active' : ''; ?>">All Contacts</a>
            <a href="?filter=sales" class="<?php echo $filter == 'sales' ? 'active' : ''; ?>">Sales Leads</a>
            <a href="?filter=support" class="<?php echo $filter == 'support' ? 'active' : ''; ?>">Support</a>
            <a href="?filter=assigned" class="<?php echo $filter == 'assigned' ? 'active' : ''; ?>">Assigned to me</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?php echo $contact['title'] . ' ' . $contact['firstname'] . ' ' . $contact['lastname']; ?></td>
                        <td><?php echo $contact['email']; ?></td>
                        <td><?php echo $contact['company']; ?></td>
                        <td><?php echo $contact['type']; ?></td>
                        <td><a href="view_contact.php?id=<?php echo $contact['id']; ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="new_contact.php" class="btn">Add New Contact</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</body>
</html>