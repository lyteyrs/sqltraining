<?php
include "auth_session.php";
require_once 'server.php';
$statement = $pdo->prepare('SELECT * FROM register_course ORDER BY create_date DESC');
$statement->execute();
$courses = $statement->fetchAll(PDO::FETCH_ASSOC);
require "header.php";
?>
<title>Home Page</title>
</head>

<body>
   <div class="container">
   <h2 class="my-5">Hi, <?php echo $_SESSION['username']; ?></h2>
    <h1>Add Course Page</h1>
    <p>
        <a href="courses.php" class="btn btn-success">Add Course</a>
    </p>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Course Name</th>
      <th scope="col">Date Added</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($courses as $i => $course): ?>
    <tr>
      <th scope="row"><?php echo $i + 1 ?></th>
      <td><?php echo $course['courses'] ?></td>
      <td><?php echo $course['create_date'] ?></td>
      <td>
        <a href="edit.php?id=<?php echo $course['id'] ?>" class="btn btn-outline-primary">Edit</a>
        <form style="display: inline-block;" action="delete.php" method="post">
          <input type="hidden" name="id" value="<?php echo $course['id'] ?>">
          <button type="submit" class="btn btn-outline-danger">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>
  </table>
  <p>
    <a href="logout.php" class="btn btn-danger">Log Out</a>
  </p>
   </div>
</body>
</html>

