<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Post</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p>
        Post updated successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/posts/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Editing Post: <?php echo escape($entry->title); ?>
            </div>
            <div class="card-body">
                <input type="text" name="title" id="title" value="<?php echo escape($entry->title); ?>"
                       class="form-control" required/>
                <label class="control-label col-md-3" for="title">
                    Title
                </label>
                <textarea name="content" id="content" class="form-text form-control"
                          required><?php echo escape($entry->content); ?></textarea>
                <label class="control-label col-md-3" for="content">
                    Content
                </label>
                <br/>
                <button type="submit" name="save" id="save" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Save
                </button>
                <a href="/app/index.php/dashboard/posts/delete?id=<?php echo escape($entry->id); ?>"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>