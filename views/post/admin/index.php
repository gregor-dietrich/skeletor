<?php include __DIR__ . "/../../layout/dashboard/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">All Posts</h1>
    </div>
    <a class="btn btn-primary" href="/app/index.php/dashboard/posts/add">
        Add New Post
    </a>
    <br /><br />
    <div class="table-responsive">
        <table class="table table-striped table-sm">
        <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($posts AS $post): ?>
            <tr>
              <td><?php echo escape($post->id); ?></td>
              <td><a href="/app/index.php/dashboard/posts/edit?id=<?php echo escape($post->id); ?>"><?php echo escape($post->title); ?></a></td>
              <td>
                <a href="/app/index.php/dashboard/posts/delete?id=<?php echo escape($post->id); ?>" onclick="return confirm('Are you sure?')">
                  Delete
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    </div>
<?php include __DIR__ . "/../../layout/dashboard/footer.php"; ?>