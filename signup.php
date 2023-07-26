<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <!--Icon-->
    <!--Font-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<body>
    <?php
    session_start();
    include "db.php";
    if (isset($_POST['signup'])) {
        $consulta = "INSERT INTO  users (first_name,last_name,username,email,password,avatar) 
                values ('{$_POST['firstname']}','{$_POST['lastname']}','{$_POST['username']}','{$_POST['email']}',SHA2('{$_POST['password']}', 256),'images/{$_POST['picture']}')";
        try {
            $resultado = $conexion->query($consulta);
            if ($resultado) {
                $_SESSION['registration_success'] = true;
                header("Location: signin.php");
                exit();
            } else {
                echo '<div class="alert alert-danger" role="alert">Registration failed!</div>';
            }
        } catch (Exception $e) {
            echo "Error executing query: " . $e->getMessage();
        }
    }
    ?>

    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="fn" class="form-label">First Name</label>
                <input name="firstname" type="text" class="form-control" id="fn" placeholder="Enter Your First Name" pattern="[A-Za-z]+" title="Please enter only letters" required>
            </div>
            <div class="mb-3">
                <label for="ln" class="form-label">Last Name</label>
                <input name="lastname" type="text" class="form-control" id="ln" placeholder="Enter Your Last Name" pattern="[A-Za-z]+" title="Please enter only letters" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input name="username" type="text" class="form-control" id="username" placeholder="Enter Username" pattern="[A-Za-z]+" title="Please enter only letters" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="Email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Enter password" required>
            </div>
            <div class="mb-3">
                <label for="profile-picture" class="form-label">Profile Picture</label>
                <div class="input-group">
                    <input name="picture" type="file" class="form-control" id="profile-picture" required>
                </div>
            </div>
            <?php if (isset($error)) { ?>
                <div style="color: red;">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
            <button type="submit" class="btn btn-primary" name="signup">Sign up</button>
            <br>
            <p class="d-inline">Already have an account? <a class="nav-link d-inline" href="signin.php">Sign in</a></p>
        </form>
    </div>

</body>

</html>
