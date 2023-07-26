<?php
include 'db.php';
require('partials/header.php');

function secure_output($value)
{
    return htmlspecialchars($value);
}

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $query = "SELECT posts.id id, users.avatar ava, posts.post_image pic, posts.title tit, posts.post_date date, posts.post_text text, categories.name cat, users.first_name fn, users.last_name ln 
    FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON users.id = posts.author_id WHERE posts.id = $postId";
    $result = $conexion->query($query);
    $post = $result->fetch_object();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        .post-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .post-card {
            max-width: 700px;
        }

        .post-image {
            width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <br>
    <div class="post-container">
        <div class="container">
            <div class="row mt-6">
                <?php if ($post) { ?>
                    <div class="col-md-6 mx-auto">
                        <div class="card post-card">
                            <img src="<?php echo secure_output($post->pic); ?>" class="card-img-top post-image" alt="Post Image">

                            <div class="card-body">
                                <h1 class="card-title"><?php echo secure_output($post->tit); ?></h1>
                                <h6 class="badge rounded-pill text-bg-info"><?php echo secure_output($post->cat); ?></h6>
                                <p class="card-text"><?php echo secure_output($post->text); ?></p><br><br>
                                <p class="blockquote-footer text-end mb-0"><b><?php echo secure_output($post->fn . " " . $post->ln) ?></b></p>
                                <p class="text-end" style="color: grey;"><?php echo secure_output($post->date); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-8 mx-auto">
                        <h1>Post Not Found</h1>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>


