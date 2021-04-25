<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

require_once 'server.php';
require_once 'datafunc.php';
define("REQUIRED_FIELD", "This field is required");
$error = [];

$newpassword = '';
$cnpassword = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newpassword = formdata('newpassword');
    $cnpassword = formdata('cnpassword');

    if (empty($error)) {
        $sql = "UPDATE register SET password = :password WHERE id = :id";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":password", $param_password, PDO::PARAM_INT);
            $param_password = password_hash($newpassword, PASSWORD_DEFAULT);
            $param_id = $_SESSION['id'];
            if ($stmt->execute()) {
                session_destroy();
                header("Location: login.php");
            } else {
                echo "<div class='alert alert-danger'>Try Again</div>";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}

require_once "header.php";
?>
<title>Passwor Reset</title>
</head>
<body>
    <div class="container">
        <form action="" method="post">
        <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="newpassword" placeholder="Password" class="form-control <?php echo isset($error['newpassword']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback">
                                <?php echo $error['newpassword'] ?? '' ?>
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="cnpassword" placeholder="Confirm Password" class="form-control <?php echo isset($error['cnpassword']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback">
                                <?php echo $error['cnpassword'] ?? '' ?>
                            </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</hml>