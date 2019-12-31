<?php include __DIR__ . "/../../layout/dashboard/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit User</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p>
        User updated successfully.
    </p>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <p>
        <?php echo $error; ?>
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/users/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                <?php echo escape($entry->username); ?>
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
                    Password
                </label>
                <input type="password" name="password_confirm" id="password_confirm" value=""
                       class="form-control" required/>
                <label class="control-label col-md-3" for="password_confirm">
                    Confirm Password
                </label>
                <br />
                <input type="submit" name="save" value="Save" id="save" class="btn btn-primary"/>
                <a href="/app/index.php/dashboard/users/delete?id=<?php echo escape($entry->id); ?>"
                   class="btn btn-primary"
                   onclick="return confirm('Are you sure?')">
                    Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/dashboard/footer.php"; ?>