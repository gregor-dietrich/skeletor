<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">All Posts</h1>
    </div>
    <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="/app/index.php/dashboard/posts/add">
        <i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Post
    </a>
    <br/><br/>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($posts AS $post): ?>
                <tr>
                    <td><?php echo escape($post->id); ?></td>
                    <td>
                        <a href="/app/index.php/dashboard/posts/edit?id=<?php echo escape($post->id); ?>"><?php echo escape($post->title); ?></a>
                    </td>
                    <td>
                        <a href="/app/index.php/dashboard/posts/edit?id=<?php echo escape($post->id); ?>"
                           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                        </a>
                        <a href="/app/index.php/dashboard/posts/delete?id=<?php echo escape($post->id); ?>"
                           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                           onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>