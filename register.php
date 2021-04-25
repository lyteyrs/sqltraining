<?php
require_once 'server.php';
require_once 'datafunc.php';
define("REQUIRED_FIELD", "This field is required");
$error = [];

//Variables for users input
$firstname = '';
$lastname = '';
$username = '';
$email = '';
$password = '';
$cpassword = '';

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Getting input from the form
    $firstname = formdata('firstname');
    $lastname = formdata('lastname');
    $username = formdata('username');
    $email = formdata('email');
    $password = formdata('password');
    $cpassword = formdata('cpassword');

    //form validation
    if (!$username) {
        $error['username'] = REQUIRED_FIELD;
    } elseif (strlen($username) < 6 || strlen($username) > 16) {
        $error['username'] = "Min of 6 or Max of 16 character";
    }

    if (!$firstname) {
        $error['firstname'] = REQUIRED_FIELD;
    }
    if (!$lastname) {
        $error['lastname'] = REQUIRED_FIELD;
    }
    if (!$email) {
        $error['email'] = REQUIRED_FIELD;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Please provide a valid email";
    }
    if (!$password) {
        $error['password'] = REQUIRED_FIELD;
    }
    if (!$cpassword) {
        $error['cpassword'] = REQUIRED_FIELD;
    } elseif ($password !== $cpassword) {
        $error['cpassword'] = 'Password does not match';
    }
    if (empty($error)) {
        //inserting into the database
        $statment = $pdo->prepare("INSERT INTO register (firstname, lastname, username, email, password, cpassword, create_date)
            VALUES(:firstname, :lastname, :username, :email, :password, :cpassword, :date)");
        $statment->bindValue(':firstname', $firstname);
        $statment->bindValue(':lastname', $lastname);
        $statment->bindValue(':username', $username);
        $statment->bindValue(':email', $email);
        $statment->bindValue(':password', $password);
        $statment->bindValue(':cpassword', $cpassword);
        $statment->bindValue(':date', date('Y-m-d H:i:s'));
        //set parameter
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $statment->execute();
    }

    header('Location: login.php');
}

?>
<?php require_once 'header.php';?>
<title>Login</title>
</head>

<body>
    <div class="container">
        <h2>Welcome, Register your account here!!!</h2>
        <form action="" method="post">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstname" class="form-control <?php echo isset($error['firstname']) ? 'is-invalid' : '' ?>" placeholder="First Name">
                        <div class="invalid-feedback">
                            <?php echo $error['firstname'] ?? '' ?>
                        </div>
                    </div>
                </div>
                <div class="col">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lastname" placeholder="Last Name" class="form-control <?php echo isset($error['lastname']) ? 'is-invalid' : '' ?>">
                            <div class="invalid-feedback">
                                <?php echo $error['lastname'] ?? '' ?>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col">
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
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email Address" class="form-control <?php echo isset($error['email']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback">
                                <?php echo $error['email'] ?? '' ?>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" class="form-control <?php echo isset($error['password']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback">
                                <?php echo $error['password'] ?? '' ?>
                            </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="cpassword" placeholder="Confirm Password" class="form-control <?php echo isset($error['cpassword']) ? 'is-invalid' : '' ?>">
                        <div class="invalid-feedback">
                                <?php echo $error['cpassword'] ?? '' ?>
                            </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <p>
                Already have an account? <a href="login.php" class="btn btn-outline-primary">Login</a>
            </p>
        </form>
    </div>
</body>
</html>
