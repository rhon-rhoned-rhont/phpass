<?php
session_start();

if (!isset($_SESSION['blog_posts'])) {
    $_SESSION['blog_posts'] = [];
}

if (isset($_POST['add_post'])) {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $_SESSION['blog_posts'][] = [
            'title' => $title,
            'content' => $content
        ];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

if (isset($_GET['remove_post'])) {
    $post_id = (int)$_GET['remove_post'];
    unset($_SESSION['blog_posts'][$post_id]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random BS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .left-side {
            background-color: black;
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        .create-blog {
            width: 80%;
            color: white;
            text-align: center;
        }

        .create-blog h1 {
            color: white;
        }

        .create-blog form {
    display: flex;
    flex-direction: column;
    align-items: center; 
    margin-bottom: 20px;
}

.create-blog input[type="submit"] {
    width: 100%;
    max-width: 200px;
    margin-top: 10px;
    padding: 15px;
    font-size: 1.2em;
    background-color: red;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.create-blog input[type="submit"]:hover {
    background-color: #218838;
}


        .create-blog input[type="text"],
        .create-blog textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
            width: 100%;
        }

        .create-blog textarea {
            resize: vertical;
        }

        .right-side {
            background-color: green;
            width: 50%;
            color: white;
            padding: 20px;
            overflow-y: auto;
        }

        .right-side h2 {
            color: white;
            text-align: center;
        }

        .blog-posts {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .post {
            background-color: #333;
            color: white;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            cursor: pointer;
            position: relative;
        }

        .post h2 {
            margin: 0;
            font-size: 1.5em;
            color: #fff;
        }

        .post p {
            font-size: 0.9em;
            color: #ccc;
        }

        .full-content {
            display: none;
            padding-top: 10px;
        }

        .close-btn, .remove-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px;
            cursor: pointer;
            display: none;
        }

        .close-btn:hover, .remove-btn:hover {
            background-color: #c82333;
        }

        .remove-btn {
            top: 5px;
            right: 60px; 
        }

    </style>
</head>
<body>

<div class="container">
    <div class="left-side">
        <div class="create-blog">
            <h1>post-A-post</h1>
            <form action="" method="POST">
                <input type="text" name="title" placeholder="Context" required>
                <textarea name="content" placeholder="Fill it up with random mumblings" rows="5" required></textarea>
                <input type="submit" name="add_post" value="Submit">
            </form>
        </div>
    </div>

    <div class="right-side">
        <h2>Former mumblings</h2>
        <ul class="blog-posts">
            <?php foreach ($_SESSION['blog_posts'] as $id => $post) : ?>
                <li class="post" data-post-id="<?php echo $id; ?>">
                    <h2><?php echo $post['title']; ?></h2>
                    <div class="full-content">
                        <p><?php echo $post['content']; ?></p>
                        <button class="remove-btn" onclick="window.location.href='?remove_post=<?php echo $id; ?>'">Remove</button>
                    </div>
                    <button class="close-btn">----</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    document.querySelectorAll('.post').forEach(post => {
        post.addEventListener('click', function () {
            const fullContent = this.querySelector('.full-content');
            const closeBtn = this.querySelector('.close-btn');
            const removeBtn = this.querySelector('.remove-btn');

            fullContent.style.display = 'block';
            closeBtn.style.display = 'block';
            removeBtn.style.display = 'inline-block'; 
        });

        post.querySelector('.close-btn').addEventListener('click', function (event) {
            event.stopPropagation();
            const fullContent = this.parentElement.querySelector('.full-content');
            fullContent.style.display = 'none';
            this.style.display = 'none';
            this.parentElement.querySelector('.remove-btn').style.display = 'none'; 
        });
    });
</script>
</body>
</html>
