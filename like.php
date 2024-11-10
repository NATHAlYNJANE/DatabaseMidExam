<?php
session_start();
require_once "config.php";

if (isset($_POST['lipstick_id']) && isset($_SESSION["id"])) {
    $lipstick_id = $_POST['lipstick_id'];
    $user_id = $_SESSION["id"];

    // Check if user already liked the product
    $check_like = $pdo->prepare("SELECT * FROM likes WHERE user_id = :user_id AND lipstick_id = :lipstick_id");
    $check_like->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $check_like->bindParam(":lipstick_id", $lipstick_id, PDO::PARAM_INT);
    $check_like->execute();

    if ($check_like->rowCount() > 0) {
        // Unlike if already liked
        $unlike = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND lipstick_id = :lipstick_id");
        $unlike->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $unlike->bindParam(":lipstick_id", $lipstick_id, PDO::PARAM_INT);
        $unlike->execute();
    } else {
        // Like if not already liked
        $like = $pdo->prepare("INSERT INTO likes (user_id, lipstick_id) VALUES (:user_id, :lipstick_id)");
        $like->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $like->bindParam(":lipstick_id", $lipstick_id, PDO::PARAM_INT);
        $like->execute();
    }
}

header("location: dashboard.php");
exit;
