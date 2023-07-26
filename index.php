<?php
include 'db.php';
require('partials/header.php');
?>

<?php
function secure_output($value)
{
    return htmlspecialchars($value);
}
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
</head>

<style>
    body {
        font-family: "Montserrat", sans-serif;
    }

    .text-truncate-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<body>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="container-md">
            <div class="row h-50 mt-5">
                <?php
                $resultado = $conexion->query('SELECT posts.id id, users.avatar ava, posts.post_image pic, posts.title tit, posts.post_date date, posts.post_text text, categories.name cat, users.first_name fn, users.last_name ln 
                FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON users.id = posts.author_id order by posts.id');

                $post = $resultado->fetch_object();

                while ($post !== null) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="img-container mx-auto text" style="max-width: 80%;">
                            <img src="<?php echo secure_output($post->pic); ?>" class="round img-fluid rounded-5">
                            <div class="caption">
                                <span class="badge rounded-pill text-bg-info"><?php echo secure_output($post->cat); ?></span>
                                <h3><?php echo secure_output($post->tit); ?></h3>
                                <p class="text-truncate-3"><a class="view-full-text text-decoration-none text-black" href="view.php?id=<?php echo secure_output($post->id); ?>"><?php echo secure_output($post->text); ?></a></p>
                                <div class="avatar">
                                    <img class="rounded float-left" style="width:10%" src="<?php echo secure_output($post->ava); ?>">
                                    <p style="display:inline-block;margin:0;" class="blockquote-footer"><b><?php echo secure_output(ucfirst($post->fn) . " " . ucfirst($post->ln)) ?></b></p>
                                    <p style="color: grey;"><?php echo secure_output($post->date); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    $post = $resultado->fetch_object();
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
<?php
require('partials/footer.php');
?>
