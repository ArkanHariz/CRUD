<?php
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "crud_db";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menambahkan data
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $sql = "INSERT INTO users (name, address) VALUES ('$name', '$address')";
    $conn->query($sql);
}

// Menghapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        // Reset AUTO_INCREMENT
        $sql_reset = "ALTER TABLE users AUTO_INCREMENT = 1";
        $conn->query($sql_reset);
    } 
}

// Mengupdate data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $sql = "UPDATE users SET name='$name', address='$address' WHERE id=$id";
    $conn->query($sql);
}

// Menampilkan data
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Example</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>CRUD Example</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="address" placeholder="Address" required>
        <button type="submit" name="add">Add</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td>
                <a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
                <button onclick="editUser (<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['address']; ?>')">Edit</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div id="editForm" style="display:none;">
        <h2>Edit User</h2>
        <form method="POST" id="updateForm">
            <input type="hidden" name="id" id="editId">
            <input type="text" name="name" id="editName" required>
            <input type="text" name="address" id="editAddress" required>
            <button type="submit" name="update">Update</button>
        </form>
    </div>

    <script>
        function editUser (id, name, address) {
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editAddress').value = address;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>
