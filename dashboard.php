<?php
include 'db.php';

session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        html,
        body {
            min-width: 70vn;
            min-height: 100vh;
        }

        body {
            font-family: "Montserrat", sans-serif;
        }
    </style>
</head>



<body class="d-flex justify-content-center align-items-center bg-light">

    <div class="card p-3 shadow" style="max-width: 100%;">
        <h2 class="text-center p-3">Dashboard</h2>
        <ul class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Add Post</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Manage Post</button>
            </li>

            <?php
            // Check if the user is an admin (is_admin = 1)
            $resultado = $conexion->prepare("SELECT is_admin FROM users WHERE users.id = ?");
            $resultado->bind_param("i", $_SESSION["us"]);
            $resultado->execute();
            $result = $resultado->get_result();

            if ($result->fetch_assoc()["is_admin"] == 1) {
                $_SESSION['is_admin'] = true; // Set the session variable to true if the user is an admin
                echo '
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="nav-add-user-tab" data-bs-toggle="tab" data-bs-target="#nav-add-user" type="button" role="tab" aria-controls="nav-add-user" aria-selected="false">Add User</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="nav-manage-user-tab" data-bs-toggle="tab" data-bs-target="#nav-manage-user" type="button" role="tab" aria-controls="nav-manage-user" aria-selected="false">Manage User</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="nav-add-category-tab" data-bs-toggle="tab" data-bs-target="#nav-add-category" type="button" role="tab" aria-controls="nav-add-category" aria-selected="false">Add Category</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="nav-manage-category-tab" data-bs-toggle="tab" data-bs-target="#nav-manage-category" type="button" role="tab" aria-controls="nav-manage-category" aria-selected="false">Manage Category</button>
    </li>
    ';
            } else {
                $_SESSION['is_admin'] = false; // Set the session variable to false if the user is not an admin
            }
            ?>


        </ul>
        <div class="tab-content p-3 border bg-light" id="nav-tabContent">
            <!----------------------------------------------------------------------------------------------------------->
            <?php
            if (isset($_POST['submit'])) {
                $post_date = date('Y-m-d H:i:s');

                $title = $_POST['title'];
                $author_id = $_SESSION['us'];
                $category_id = $_POST['category'];
                $content = $_POST['content'];
                $image_path = "images/" . $_POST['image']; // Set the destination path for the image


                // Use prepared statements to prevent SQL injection
                $consulta = "INSERT INTO posts (title, author_id, category_id, post_date, post_text, post_image) 
        VALUES (?, ?, ?, ?, ?, ?)";
                try {
                    $statement = $conexion->prepare($consulta);
                    $statement->bind_param("siisss", $title, $author_id, $category_id, $post_date, $content, $image_path);
                    $statement->execute();
                    $resultado = $statement->get_result();
                    // You can add a success message here if needed
                    echo '<div class="alert alert-success" role="alert">Post inserted successfully!</div>';
                } catch (Exception $e) {
                    echo "Error executing query: " . $e->getMessage();
                }
            }
            ?>


            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="container">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" pattern="[A-Za-z\s:-]+(?:\d+[A-Za-z]+)?" title="Please enter only letters" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <?php
                            $resultado = $conexion->query('SELECT id,name FROM `categories`');
                            $category = $resultado->fetch_object();
                            ?>
                            <select class="form-control" id="category" name="category" required>
                                <?php
                                while ($category != null) {
                                ?>
                                    <option value="<?php echo $category->id; ?>">
                                        <?php echo $category->name; ?>
                                    </option>
                                <?php
                                    $category = $resultado->fetch_object();
                                }
                                ?>
                            </select>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3" pattern="[A-Za-z\s:-]+(?:\d+[A-Za-z]+)?" title="Please enter only letters" required></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" id="image" name="image" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="submit">Add</button>
                        <button type="reset" class="btn btn-primary" name="reset">Reset</button>
                        <a href="index.php" class="btn btn-primary" name="submit">Return</a>
                    </form>



                </div>

            </div>

            <!----------------------------------------------------------------------------------------------------------->

            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <?php
                if (isset($_POST['delete'])) {
                    $delete_cod = $_POST['delete'];

                    // Use prepared statements to prevent SQL injection
                    $consulta = "DELETE FROM posts WHERE id = ?";
                    try {
                        $statement = $conexion->prepare($consulta);
                        $statement->bind_param("i", $delete_cod);
                        $statement->execute();
                        $resultado = $statement->get_result();
                        if ($statement->affected_rows > 0) {
                            echo '<div class="alert alert-success" role="alert">Post deleted successfully!</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Post inserted successfully!</div>';
                        }
                    } catch (Exception $e) {
                        echo "Error executing query: " . $e->getMessage();
                    }
                }
                ?>
                <div class="container">
                    <?php
                    if ($_SESSION['is_admin'] == true) {
                        // If the user is an admin, select all posts from all users
                        $consulta = "SELECT posts.id cod, posts.title tit, categories.name catn,users.username un
            FROM categories 
            JOIN posts ON posts.category_id = categories.id join users on users.id=posts.author_id";
                        $resultado = $conexion->query($consulta);
                    } else {
                        // If the user is not an admin, select posts that belong to the user
                        $consulta = "SELECT posts.id cod, posts.title tit, categories.name catn,users.username un
            FROM categories 
            JOIN posts ON posts.category_id = categories.id join users on users.id=posts.author_id
            WHERE posts.author_id = ?";
                        $resultado = $conexion->prepare($consulta);
                        $resultado->bind_param("i", $_SESSION["us"]);
                        $resultado->execute();
                        $resultado = $resultado->get_result();
                    }

                    if ($resultado->num_rows > 0) {
                        while ($manage = $resultado->fetch_object()) {

                    ?>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="hidden" name="delete" value="<?php echo $manage->cod ?>">
                                            <p><?php echo htmlspecialchars($manage->tit); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <p class="badge rounded-pill text-bg-info"><?php echo htmlspecialchars($manage->catn); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <p class="badge rounded-pill text-bg-secondary"><?php echo htmlspecialchars($manage->un); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-danger btn-block">Delete</button>
                                    </div>
                                </div>
                                <hr>
                            </form>

                    <?php
                        }
                    } else {
                        echo "No posts found.";
                    }
                    ?>
                    </form>
                </div>
            </div>

            <!----------------------------------------------------------------------------------------------------------->

            <div class="tab-pane fade" id="nav-add-user" role="tabpanel" aria-labelledby="nav-add-user-tab">
                <?php
                if (isset($_POST['add'])) {
                    $is_admin = ($_POST['is_admin'] == 'yes') ? 1 : 0;
                    $consulta = "INSERT INTO users (first_name, last_name, username, email, password, avatar, is_admin) 
                VALUES ('{$_POST['firstname']}', '{$_POST['lastname']}', '{$_POST['username']}', '{$_POST['email']}', SHA2('{$_POST['password']}', 256), 'images/{$_POST['picture']}', $is_admin)";
                    #print_r($consulta);
                    try {
                        $resultado = $conexion->query($consulta);
                        echo '<div class="alert alert-success" role="alert">User inserted successfully!</div>';
                    } catch (Exception $e) {
                        echo "Error executing query: " . $e->getMessage();
                    }
                }
                ?>
                <div class="container">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="fn" class="form-label">First Name</label>
                            <input name="firstname" type="text" class="form-control" id="title" placeholder="Enter Your First Name" pattern="[A-Za-z]+" title="Please enter only letters" required>
                        </div>
                        <div class="mb-3">
                            <label for="ln" class="form-label">Last Name</label>
                            <input name="lastname" type="text" class="form-control" id="title" placeholder="Enter Your Last Name" pattern="[A-Za-z]+" title="Please enter only letters" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input name="username" type="text" class="form-control" id="title" placeholder="Enter Username" pattern="[A-Za-z]+" title="Please enter only letters" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control" id="title" placeholder="Enter password" required>
                        </div>
                        <div class="mb-3">
                            <label for="profile-picture" class="form-label">Profile Picture</label>
                            <div class="input-group">
                                <input name="picture" type="file" class="form-control" id="image" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="is-admin" class="form-label">Is Admin?</label>
                            <select name="is_admin" class="form-control" id="is-admin" required>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="add">Add</button>
                        <button type="reset" class="btn btn-primary" name="reset">Reset</button>
                        <a href="index.php" class="btn btn-primary" name="return">Return</a>
                    </form>
                </div>
            </div>

            <!----------------------------------------------------------------------------------------------------------->

            <div class="tab-pane fade" id="nav-manage-user" role="tabpanel" aria-labelledby="nav-manager-user-tab">
                <?php
                if (isset($_POST['delete_user'])) {
                    $delete_cod = $_POST['delete_user'];

                    // Check if the user is related to other posts
                    $check_query = "SELECT COUNT(*) AS count FROM posts WHERE author_id = ?";
                    try {
                        $check_statement = $conexion->prepare($check_query);
                        $check_statement->bind_param("i", $delete_cod);
                        $check_statement->execute();
                        $check_result = $check_statement->get_result();
                        $count = $check_result->fetch_assoc()['count'];

                        if ($count > 0) {
                            echo '<div class="alert alert-danger" role="alert">This user is related to other posts. You cannot delete it.</div>';
                        } else {
                            // Use prepared statements to prevent SQL injection
                            $delete_query = "DELETE FROM users WHERE id = ?";
                            try {
                                $delete_statement = $conexion->prepare($delete_query);
                                $delete_statement->bind_param("i", $delete_cod);
                                $delete_statement->execute();
                                if ($delete_statement->affected_rows > 0) {
                                    echo '<div class="alert alert-success" role="alert">User deleted successfully!</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Failed to delete user!</div>';
                                }
                            } catch (Exception $e) {
                                echo "Error executing query: " . $e->getMessage();
                            }
                        }
                    } catch (Exception $e) {
                        echo "Error executing query: " . $e->getMessage();
                    }
                }
                ?>
                <div class="container">
                    <?php
                    $resultado = $conexion->prepare('SELECT id, email, first_name, last_name, is_admin FROM users ORDER BY id');
                    $resultado->execute();
                    $result = $resultado->get_result();

                    if ($result->num_rows > 0) {
                        while ($manage = $result->fetch_object()) {
                    ?>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="row align-items">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="hidden" name="delete_user" value="<?php echo $manage->id ?>">
                                            <p><?php echo htmlspecialchars($manage->first_name . " " . $manage->last_name); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="badge text-bg-dark"><?php echo htmlspecialchars($manage->email); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <?php if ($manage->is_admin == 1) : ?>
                                                <p class="badge text-bg-success">Yes</p>
                                            <?php else : ?>
                                                <p class="badge text-bg-danger">No</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-danger btn-block">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>
                    <?php
                        }
                    } else {
                        echo "No users found.";
                    }
                    ?>
                </div>
            </div>


            </ <!----------------------------------------------------------------------------------------------------------->
            <div class="tab-pane fade" id="nav-add-category" role="tabpanel" aria-labelledby="nav-add-category-tab">
                <?php
                if (isset($_POST['add_cat'])) {
                    $consulta = "INSERT INTO categories (name) VALUES ('{$_POST['catn']}')";
                    #print_r($consulta);
                    $_SESSION['notificacion'] = "category created successfully";
                    try {
                        $resultado = $conexion->query($consulta);
                        echo '<div class="alert alert-success" role="alert">Category inserted successfully!</div>';
                    } catch (Exception $e) {
                        echo "Error executing query: " . $e->getMessage();
                    }
                }
                ?>
                <div class="container">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input name="catn" type="text" class="form-control" id="title" placeholder="Enter Category Name" pattern="[A-Za-z]+" title="Please enter only letters" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="add_cat">Add</button>
                        <button type="reset" class="btn btn-primary" name="reset">Reset</button>
                        <a href="index.php" class="btn btn-primary" name="submit">Return</a>
                    </form>
                </div>

            </div>
            <!----------------------------------------------------------------------------------------------------------->
            <div class="tab-pane fade" id="nav-manage-category" role="tabpanel" aria-labelledby="nav-manage-category-tab">
                <?php
                if (isset($_POST['delete_cat'])) {
                    $delete_cod_ = $_POST['delete_cat'];

                    // Check if the category is related to other posts
                    $check_query = "SELECT COUNT(*) AS count FROM posts WHERE category_id = ?";
                    try {
                        $check_statement = $conexion->prepare($check_query);
                        $check_statement->bind_param("i", $delete_cod_);
                        $check_statement->execute();
                        $check_result = $check_statement->get_result();
                        $count = $check_result->fetch_assoc()['count'];

                        if ($count > 0) {
                            echo '<div class="alert alert-danger" role="alert">This category is related to other posts. You cannot delete it.</div>';
                        } else {
                            // Use prepared statements to prevent SQL injection
                            $delete_query = "DELETE FROM categories WHERE id = ?";
                            try {
                                $delete_statement = $conexion->prepare($delete_query);
                                $delete_statement->bind_param("i", $delete_cod_);
                                $delete_statement->execute();
                                if ($delete_statement->affected_rows > 0) {
                                    echo '<div class="alert alert-success" role="alert">Category deleted successfully!</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Failed to delete category!</div>';
                                }
                            } catch (Exception $e) {
                                echo "Error executing query: " . $e->getMessage();
                            }
                        }
                    } catch (Exception $e) {
                        echo "Error executing query: " . $e->getMessage();
                    }
                }
                ?>
                <div class="container">
                    <?php
                    $resultado_ = $conexion->prepare("SELECT id, name FROM categories ");
                    $resultado_->execute();
                    $result_ = $resultado_->get_result();

                    if ($result_->num_rows > 0) {
                        while ($manage_ = $result_->fetch_object()) {
                    ?>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="hidden" name="delete_cat" value="<?php echo $manage_->id ?>">
                                            <p><?php echo htmlspecialchars($manage_->id); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <p class="badge text-bg-warning"><?php echo htmlspecialchars($manage_->name); ?></p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-danger btn-block" name="delete_cat_<?php echo $manage_->id ?>">Delete</button>
                                    </div>
                                </div>
                                <hr>
                            </form>
                    <?php
                        }
                    } else {
                        echo "No categories found.";
                    }
                    ?>
                </div>
            </div>
            <!----------------------------------------------------------------------------------------------------------->
        </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>

<?php
#require('partials/footer.php');
?>
