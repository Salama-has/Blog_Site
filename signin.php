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
    include 'db.php';
    
    if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
        echo '<div class="alert alert-success" role="alert">Registration successful! You can now sign in.</div>';
        unset($_SESSION['registration_success']);
    }
    if (isset($_POST['signin'])) {
        $_SESSION["Acceso"] = "signin";
        $user = $_SESSION['username'] =  mysqli_real_escape_string($conexion, $_POST['username']);
        $pass = hash("sha256", mysqli_real_escape_string($conexion, $_POST['password']));
        $query = "SELECT * FROM users WHERE username = '$user'  AND password = '$pass'";
        $result = mysqli_query($conexion, $query);

        // Si se encuentra un usuario con las credenciales especificadas
        if (mysqli_num_rows($result) > 0) {
            //$_SESSION["login"] = $_POST['login'];
            // Acceso permitido
            // Aquí puedes redirigir al usuario a la página principal de la aplicación
            header("Location: index.php");
            exit;
        } else {
            // Acceso denegado
            // Vuelve a pedir las credenciales al usuario
            $error = "Incorrect user or password";
        }

    } 
    ?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="mb-3">
            <label for="fn" class="form-label">Username</label>
            <input name="username" type="text" class="form-control" id="fn" placeholder="Enter The Username" pattern="[A-Za-z]+" title="Please enter only letters" required>
        </div>
        <div class="mb-3">
            <label for="ln" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="ln" placeholder="Enter The Password" required>
        </div>
        <?php if (isset($error)) { ?>
            <div style="color: red;">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="signin">Sign In</button>
        <br>
        <p class="d-inline">Create account? <a class="nav-link d-inline" href="signup.php">Sign up</a></p>
    </form>
</div>

</body>

</html>
