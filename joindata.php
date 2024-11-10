<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

// Determine join type from URL, default to 'left'
$join_type = $_GET['join'] ?? 'left';

switch ($join_type) {
    case 'right':
        // Right Join: Show all lipstick data, even if no user liked the lipstick
        $sql = "SELECT lipsticks.id AS Lipstick_ID, lipsticks.name AS Lipstick, lipsticks.description, 
                       lipsticks.image_url, lipsticks.price, likes.user_id AS Liked_By_User
                FROM lipsticks 
                RIGHT JOIN likes ON lipsticks.id = likes.lipstick_id";
        break;

    case 'union':
        // Union Join: Show users and the lipsticks they liked, with null for unliked lipsticks
        $sql = "SELECT users.username AS User, lipsticks.name AS Lipstick
                FROM users
                LEFT JOIN likes ON users.id = likes.user_id
                LEFT JOIN lipsticks ON likes.lipstick_id = lipsticks.id
                UNION
                SELECT users.username AS User, lipsticks.name AS Lipstick
                FROM users
                RIGHT JOIN likes ON users.id = likes.user_id
                RIGHT JOIN lipsticks ON likes.lipstick_id = lipsticks.id";
        break;

    default:
        // Left Join: Show all users who logged in and the lipsticks they liked
        $sql = "SELECT users.id AS User_ID, users.username AS Username, lipsticks.name AS Lipstick
                FROM users
                LEFT JOIN likes ON users.id = likes.user_id
                LEFT JOIN lipsticks ON likes.lipstick_id = lipsticks.id";
        break;
}

$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000;
            color: #fff;
        }
        .navbar {
            background-color: #333;
        }
        .navbar a {
            color: #fff !important;
        }
        .container-buttons {
            margin: 20px;
            text-align: center;
        }
        .btn {
            margin: 5px;
        }
        .table-container {
            background-color: #fff;
            color: #000;
            border-radius: 8px;
            padding: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Lipstick Store</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="joindata.php">joindata</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container-buttons">
        <a href="joindata.php?join=left" class="btn btn-light">Logged-in Users with Liked Lipsticks</a>
        <a href="joindata.php?join=right" class="btn btn-light">All Lipsticks with Likes</a>
        <a href="joindata.php?join=union" class="btn btn-light">Users and Liked Lipsticks (Including Unliked)</a>
    </div>

    <div class="container mt-4 table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <?php if ($join_type === 'left'): ?>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Lipstick</th>
                    <?php elseif ($join_type === 'right'): ?>
                        <th>Lipstick ID</th>
                        <th>Lipstick</th>
                        <th>Description</th>
                        <th>Image URL</th>
                        <th>Price</th>
                        <th>Liked By User</th>
                    <?php else: ?>
                        <th>User</th>
                        <th>Lipstick</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch()): ?>
                    <tr>
                        <?php if ($join_type === 'left'): ?>
                            <td><?php echo htmlspecialchars($row['User_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Username']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lipstick'] ?? 'None'); ?></td>
                        <?php elseif ($join_type === 'right'): ?>
                            <td><?php echo htmlspecialchars($row['Lipstick_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lipstick']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['image_url']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($row['Liked_By_User'] ?? 'None'); ?></td>
                        <?php else: ?>
                            <td><?php echo htmlspecialchars($row['User']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lipstick'] ?? 'None'); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
