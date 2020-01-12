<?php include __DIR__ . "/../../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User Group</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert alert-success">
        User Group updated successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/user_groups/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Editing User Group: <?php echo escape($entry->name); ?>
            </div>
            <div class="card-body">
                <input type="text" name="name" id="name" value="<?php echo escape($entry->name); ?>"
                       class="form form-control col-md-4" required/>
                <label class="control-label col-md-2" for="name">
                    User Group Name
                </label>
                <br/>
                <button type="submit" name="save" id="save"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Save
                </button>
                <a href="/app/index.php/dashboard/user_groups/delete?id=<?php echo escape($entry->id); ?>"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../../layout/admin/footer.php"; ?>