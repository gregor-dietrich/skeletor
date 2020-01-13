<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Static Page</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert alert-success">
        Static Page updated successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/pages/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Editing Static Page: <?php echo escape($entry->title); ?>
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
                <button type="submit" name="save" id="save"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Save
                </button>
                <a href="/app/index.php/dashboard/pages/delete?id=<?php echo escape($entry->id); ?>"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>