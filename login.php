<?php
session_start();
require_once 'server.php';
require_once 'datafunc.php';
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

define("REQUIRED_FIELD", "This field is required");
$error = [];

$username = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = formdata('username');
    $password = formdata('password');

    //Validation
    if (!$username) {
        $error['username'] = REQUIRED_FIELD;
    }

    if (!$password) {
        $error['password'] = REQUIRED_FIELD;
    }
    if (empty($error)) {
        $sql = "SELECT id, username, password FROM register WHERE username = :username";
        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $id = $row["id"];
                        $username = $row["username"];
                        $password = $row["password"];
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        // Redirect user to welcome page
                        header("location: index.php");
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $error[] = "Invalid username or password";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
}

?>

<?php require_once 'header.php';?>
<title>Login</title>
</head>
<body>
    <div class="container">
        <h2>Login Page</h2>
        <form action="" method="post">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" placeholder="Username" class="form-control <?php echo isset($error['username']) ? 'is-invalid' : '' ?>">
                            <div class="invalid-feedback">
                                    <?php echo $error['username'] ?? '' ?>
                                </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control <?php echo isset($error['password']) ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback">
                                <?php echo $error['password'] ?? ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="reset.php" type="submit" class="btn btn-warning">Reset</a>
                <p>
                    Don't have an account? <a href="register.php" class="btn btn-outline-primary">Register</a>
                </p>
            </form>
        </div>
</body>
</html>
