<?php include __DIR__ . "/../layout/header.php"; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="container">
            <h1>Startseite des Blogs</h1>
            <p>Das hier ist die Startseite des Blogs.</p>
            <div class="card">
                <div class="card-header"><h3>Alle Einträge des Blogs</h3></div>
                <div class="card-body">
                    <ul>
                        <?php foreach ($posts AS $post): ?>
                        <li>
                            <a href="post?id=<?php echo escape($post->id); ?>">
                            <?php echo escape($post->title); ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>