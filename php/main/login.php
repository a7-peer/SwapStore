<?php
include("../partials/function.php");
session_start(); // Start the session at the top

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile_number = trim($_POST["mobile_number"]);
    $password = $_POST["password"];

    // Validation
    if (empty($mobile_number) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Query to fetch hashed password
        $sql = "SELECT password FROM `signup` WHERE `mobile_number` = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $mobile_number);
            $stmt->execute();
            $stmt->bind_result($hashedPassword);
            $stmt->store_result();

            // Check if user exists
            if ($stmt->num_rows == 1) {
                $stmt->fetch();
                if (password_verify($password, $hashedPassword)) {
                    // Successful login
                    $_SESSION["mobile_number"] = $mobile_number; // Store mobile number in session
                    header("Location: welcome.php");
                    exit();
                } else {
                    $error = "Invalid password.";
                }
            } else {
                $error = "No account found with this mobile number.";
            }
            $stmt->close();
        } else {
            $error = "Database error. Please try again later.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up for SwapStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<!-- Heading -->
<div class="store-container">
    <h1 class="store-name">SwapStore</h1>
</div>

<div class="container form-container">

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

        <div class="mb-3">
            <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Log In </button>
        <button type="button" class="btn btn-secondary w-100 mt-2" onclick="window.location.href='signup.php'">Create an account?</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>