<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add User</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p>
        User added successfully.
    </p>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <p>
        <?php echo $error; ?>
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/users/add" class="form-horizontal">
            <div class="card-header">
                New User
            </div>
            <div class="card-body">
                <input type="text" name="username" id="username" value=""
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
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>