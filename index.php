<?php 
session_start();

// Redirect to login page if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'dbConfig.php';
require_once 'HandleForms.php'; 

// Initialize the HandleForms class with the PDO instance from dbConfig
$handleForms = new HandleForms($pdo);

// Fetch all customers
$customers = $handleForms->getAllCustomers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affordable Furniture Management</title>
    <style>
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Container */
.container {
    width: 90%;
    max-width: 1200px;
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #444;
    margin-bottom: 15px;
    text-align: center;
}

h1 {
    font-size: 24px;
}

/* Logout and Add Customer Buttons */
.btn {
    padding: 8px 12px;
    font-size: 14px;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.btn-success {
    background-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
}

.btn:hover {
    opacity: 0.9;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #dddddd;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background-color: #007bff;
    color: #ffffff;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #e6f7ff;
}

/* Actions */
form {
    display: inline-block;
}

button[type="submit"] {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button.btn {
    background-color: #007bff;
    color: white;
}

button.btn-danger {
    background-color: #dc3545;
}

button:hover {
    opacity: 0.8;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Affordable Furniture Management System</h1>
        <div style="text-align: right;">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <!-- Add New Customer Button -->
        <div style="margin-bottom: 20px;">
            <a href="add_customer.php" class="btn btn-success">Add New Customer</a>
        </div>

        <!-- Display All Customers -->
        <h2>Customer List</h2>
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Created By</th>
                    <th>Last Updated By</th>
                    <th>Last Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($customers): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['customer_id']); ?></td>
                            <td><?php echo htmlspecialchars($customer['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($customer['address']); ?></td>
                            <td><?php echo htmlspecialchars($customer['created_by_email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['updated_by_email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['updated_at']); ?></td>
                            <td>
                                <form action="edit_customer.php" method="GET" style="display: inline;">
                                    <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer['customer_id']); ?>">
                                    <button type="submit" class="btn">Edit</button>
                                </form>
                                <form action="delete_customer.php" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                    <input type="hidden" name="customer_id" value="<?php echo htmlspecialchars($customer['customer_id']); ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="10" style="text-align: center;">No customers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

