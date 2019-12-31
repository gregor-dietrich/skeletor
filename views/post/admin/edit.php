<?php include __DIR__ . "/../../layout/dashboard/header.php"; ?>
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
                <input type="text" name="title" id="title" value="<?php echo escape($entry->title); ?>"
                       class="form-control" required/>
            </div>
            <div class="card-body">
                <textarea name="content" id="content" class="form-text form-control"
                          required><?php echo escape($entry->content); ?></textarea>
                <br/>
                <input type="submit" name="save" value="Save" id="save" class="btn btn-primary"/>
                <a href="/app/index.php/dashboard/posts/delete?id=<?php echo escape($entry->id); ?>"
                   class="btn btn-primary"
                   onclick="return confirm('Are you sure?')">
                    Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/dashboard/footer.php"; ?>