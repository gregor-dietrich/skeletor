<?php include __DIR__ . "/../../layout/dashboard/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">All Posts</h1>
        <a class="btn btn-primary" href="/app/index.php/dashboard/posts/add">
            Add New Post
        </a>
    </div>
    <ul>
        <?php foreach ($posts AS $post): ?>
        <li>
            <a href="/app/index.php/dashboard/posts/edit?id=<?php echo escape($post->id); ?>">
            <?php echo escape($post->title); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
<?php include __DIR__ . "/../../layout/dashboard/footer.php"; ?>