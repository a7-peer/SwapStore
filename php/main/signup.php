
<?php
include("../partials/function.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$firstName = trim($_POST['first_name']);
$lastName = trim($_POST['last_name']);
$month = $_POST['month'];
$date = $_POST['date'];
$year = $_POST['year'];
$mobile = trim($_POST['mobile_number']);
$password = $_POST['password'];
if(empty($firstName) || empty($lastName) || empty($month) || empty($date) || empty($year)) {
    $error = "All fields must be filled";
}
else if(!is_numeric($mobile) || strlen($mobile) < 10) {
    $error = "Mobile number must be greater than 11 digits";
}
else if (!checkdate($month, $date, $year)) {
    $error = "Invalid date";
}
else{
    $Csql = "SELECT COUNT(*) FROM `signup` WHERE `mobile_number` = ?";
    $checkStmt = $conn->prepare($Csql);
    $checkStmt->bind_param("s", $mobile);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();
    if ($count > 0) {
            $error = "This mobile number is already registered.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the database
            $sql = "INSERT INTO `signup` (`first_name`, `last_name`, `birth_month`, `birth_date`, `birth_year`, `mobile_number`, `password`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiiiss", $firstName, $lastName, $month, $date, $year, $mobile, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "An error occurred. Please try again.";
            }
            $stmt->close();
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
    <?php showError($error); ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="mb-3">
            <input type="text" class="form-control" name="first_name" placeholder="First Name">
            <input type="text" class="form-control mt-2" name="last_name" placeholder="Last Name">
        </div>
        <div class="mb-3">
            <!-- Month Dropdown -->
            <select id="month" class="form-select" name="month">
                <option selected>Month</option>
                <?php
                $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                foreach ($months as $index => $month) {
                    echo '<option value="' . ($index + 1) . '">' . $month . '</option>';
                }
                ?>
            </select>

            <!-- Date Dropdown -->
            <select id="date" class="form-select mt-2" name="date">
                <option selected>Select Date</option>
                <?php
                for ($i = 1; $i <= 31; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>

            <!-- Year Dropdown -->
            <select id="year" class="form-select mt-2" name="year">
                <option selected>Select Year</option>
                <?php
                for ($year = date("Y"); $year > 1900; $year--) {
                    echo "<option value='$year'>$year</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="mobile_number" placeholder="Mobile Number">
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" name="password" placeholder="New Password">
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100">Sign up</button>
        <button type="button" class="btn btn-secondary w-100 mt-2" onclick="window.location.href='login.php'">Already have an account?</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>