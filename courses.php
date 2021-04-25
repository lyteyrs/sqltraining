<?php
require_once 'server.php';

$errors = [];

$courses = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courses = $_POST['newcourse'];

    //Validation
    if (!$courses) {
        $errors[] = "Course is required";
    }

    if (empty($errors)) {
        //inserting into the database
        $statment = $pdo->prepare("INSERT INTO register_course (courses, create_date)
            VALUES(:courses, :date)");
        $statment->bindValue(':courses', $courses);
        $statment->bindValue(':date', date('Y-m-d H:i:s'));
        $statment->execute();

        header('Location: index.php');
    }
}
require_once 'header.php';
?>

    <title>Add Courses</title>
</head>
<body>
<h1>Add a new course</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo $error ?></div>
            <?php endforeach;?>
        </div>
    <?php endif;?>
    <form action="" method="post">
    <div class="form-group">
            <label>Add a Course</label>
            <input type="text" class="form-control" name="newcourse">
        </div><br>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </form>
</body>
</html>
