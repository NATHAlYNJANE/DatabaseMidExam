<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

// Fetch lipsticks and likes
$sql = "SELECT lipsticks.id, lipsticks.name, lipsticks.description, lipsticks.image_url, lipsticks.price,
               IF(likes.user_id IS NOT NULL, 1, 0) AS liked
        FROM lipsticks
        LEFT JOIN likes ON lipsticks.id = likes.lipstick_id AND likes.user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":user_id", $_SESSION["id"], PDO::PARAM_INT);
$stmt->execute();
$lipsticks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #333;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .container {
            margin-top: 20px;
        }
        .lipstick-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .lipstick-item {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .lipstick-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .like-button {
            background-color: #ffc107;
            color: #333;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .liked {
            background-color: #ff5722;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">Beauty Store</a>
    <div class="ml-auto">
        <a href="logout.php" class="nav-link">Logout</a>
        <a href="joindata.php" class="nav-link">joindata</a>
    </div>
</nav>

<div class="container">
    <h1>Welcome to the Beauty Store, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <div class="lipstick-container">
        <?php foreach ($lipsticks as $lipstick): ?>
            <div class="lipstick-item">
                <img src="<?php echo htmlspecialchars($lipstick['image_url']); ?>" alt="<?php echo htmlspecialchars($lipstick['name']); ?>">
                <h4><?php echo htmlspecialchars($lipstick['name']); ?></h4>
                <p><?php echo htmlspecialchars($lipstick['description']); ?></p>
                <p>$<?php echo number_format($lipstick['price'], 2); ?></p>
                <form action="like.php" method="post">
                    <input type="hidden" name="lipstick_id" value="<?php echo $lipstick['id']; ?>">
                    <button type="submit" class="like-button <?php echo $lipstick['liked'] ? 'liked' : ''; ?>">
                        <?php echo $lipstick['liked'] ? 'Liked' : 'Like'; ?>
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
