<?php include __DIR__ . "/../layout/header.php"; ?>
    <br/>

<?php if (!empty($error)): ?>
    <p class="alert-danger">
        <?php echo $error; ?>
    </p>
<?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <h3>Login</h3>
        </div>
        <form method="POST" action="login" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-3" for="username">
                    Username
                </label>
                <div class="col-md-9">
                    <input type="text" name="username" id="username" class="form-control" required/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3" for="password">
                    Password
                </label>
                <div class="col-md-9">
                    <input type="password" name="password" id="password" class="form-control" required/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input type="submit" name="login" value="Login" id="login" class="btn btn-primary"/>
                </div>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../layout/footer.php"; ?>