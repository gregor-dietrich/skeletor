<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert-success">
        User updated successfully.
    </p>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <p class="alert-danger">
        <?php echo $error; ?>
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/users/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Editing User: <?php echo escape($entry->username); ?>
            </div>
            <div class="card-body">
                <input type="text" name="username" id="username" value="<?php echo escape($entry->username); ?>"
                       class="form-control" required/>
                <label class="control-label col-md-3" for="username">
                    Username
                </label>
                <input type="password" name="password" id="password" value=""
                       class="form-control" required/>
                <label class="control-label col-md-3" for="password">
                    New Password
                </label>
                <input type="password" name="password_confirm" id="password_confirm" value=""
                       class="form-control" required/>
                <label class="control-label col-md-3" for="password_confirm">
                    Confirm New Password
                </label>
                <br/>
                <button type="submit" name="save" id="save" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Save
                </button>
                <a href="/app/index.php/dashboard/users/delete?id=<?php echo escape($entry->id); ?>"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>