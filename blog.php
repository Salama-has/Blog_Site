<?php
include 'db.php';
require 'partials/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-Yy7SdLZP+gS9HUEGkTbPn5UK4lB7rlwiY44wdN52YV9j6+OlpYDh2a1Ejlw6AtxUzEeDdC3cU9NWaeCqAakP3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .text-truncate-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="post" class="input-group mt-4">
                    <input name="search" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="container-md">
            <div class="row h-50 mt-5">
                <?php
                if (isset($_POST['search'])) {
                    $query = $_POST['search'];
                    $resultado_ = $conexion->query("SELECT posts.id id, users.avatar ava, posts.post_image pic, posts.title tit, posts.post_date date, posts.post_text text, categories.name cat, users.first_name fn, users.last_name ln 
                    FROM posts 
                    JOIN categories ON posts.category_id = categories.id 
                    JOIN users ON users.id = posts.author_id 
                    WHERE posts.title LIKE '%$query%' OR posts.post_text LIKE '%$query%' OR categories.name LIKE '%$query%' 
                    OR users.first_name LIKE '%$query%' OR users.last_name LIKE '%$query%';
                    ");
                    while ($post_ = $resultado_->fetch_object()) {
                ?>
                        <div class="col-md-4 mb-5">
                            <div class="img-container mx-auto text" style="max-width: 80%;">
                                <img src="<?php echo htmlspecialchars($post_->pic); ?>" class="round img-fluid rounded-5">
                                <div class="caption">
                                    <span class="badge rounded-pill text-bg-info"><?php echo htmlspecialchars($post_->cat); ?></span>
                                    <h3><?php echo htmlspecialchars($post_->tit); ?></h3>
                                    <p class="text-truncate-3"><a class="view-full-text text-decoration-none text-black" href="view.php?id=<?php echo htmlspecialchars($post_->id); ?>"><?php echo htmlspecialchars($post_->text); ?></a></p>
                                    <div class="avatar">
                                        <img class="rounded float-left" style="width:10%" src="<?php echo htmlspecialchars($post_->ava); ?>">
                                        <p style="display:inline-block;margin:0;" class="blockquote-footer"><b><?php echo htmlspecialchars(ucfirst($post_->fn) . " " . ucfirst($post_->ln)) ?></b></p>
                                        <p style="color: grey;"><?php echo htmlspecialchars($post_->date); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                    }
                    $post_ = $resultado_->fetch_object();
                } else {
                    $resultado = $conexion->query('SELECT posts.id id,  users.avatar ava,posts.post_image pic, posts.title tit, posts.post_date date, posts.post_text text, categories.name cat, users.first_name fn,users.last_name ln 
                    FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON users.id = posts.author_id order by posts.id');
                    $post = $resultado->fetch_object();
                    while ($post !== null) {
                ?>
                        <div class="col-md-4 mb-4">
                            <div class="img-container mx-auto text" style="max-width: 80%;">
                                <img src="<?php echo htmlspecialchars($post->pic); ?>" class="round img-fluid rounded-5">
                                <div class="caption">
                                    <span class="badge rounded-pill text-bg-info"><?php echo htmlspecialchars($post->cat); ?></span>
                                    <h3><?php echo htmlspecialchars($post->tit); ?></h3>
                                    <p class="text-truncate-3"><a class="view-full-text text-decoration-none text-black" href="view.php?id=<?php echo htmlspecialchars($post->id); ?>"><?php echo htmlspecialchars($post->text); ?></a></p>
                                    <div class="avatar">
                                        <img class="rounded float-left" style="width:10%" src="<?php echo htmlspecialchars($post->ava); ?>">
                                        <p style="display:inline-block;margin:0;" class="blockquote-footer"><b><?php echo htmlspecialchars(ucfirst($post->fn) . " " . ucfirst($post->ln)) ?></b></p>
                                        <p style="color: grey;"><?php echo htmlspecialchars($post->date); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                        $post = $resultado->fetch_object();
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>
</body>

</html>

<?php
require 'partials/footer.php';
?>
