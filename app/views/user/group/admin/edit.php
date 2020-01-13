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
        <form method="POST" action="/app/index.php/dashboard/user_groups/edit?id=<?php echo escape($entry->id); ?>&action=add"
              class="form-horizontal">
            <div class="card-header">
                Editing User Group: <?php echo escape($entry->name); ?>
            </div>
            <div class="card-body">
                <input type="text" name="name" id="name" value="<?php echo escape($entry->name); ?>"
                       class="form form-control col-md-6" required/>
                <label class="control-label col-md-6" for="name">
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
    <br/>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/user_groups/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Manage Members
            </div>
            <div class="card-body">
                <input type="text" name="username" id="username" value=""
                       class="form form-control col-md-6" required/>
                <label class="control-label col-md-6" for="username">
                    Username
                </label>
                <br/>
                <button type="submit" name="add" id="add"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Add
                </button>
                </form><br/>
                <br/>
                <h4>Currently in Group <?php echo escape($entry->name); ?>:</h4>
                <ul>
                    <?php foreach ($users AS $user): ?>
                        <li>
                            <a href="/app/index.php/dashboard/user_groups/kick?username=<?php echo escape($this->usersRepository->findID($user->user_id)->username); ?>&from=<?php echo escape($entry->id); ?>"
                               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                               onclick="return confirm('Are you sure?')" style="margin:1px;">
                                <i class="fas fa-trash-alt fa-sm text-white-50"></i>
                            </a>
                            <?php echo escape($this->usersRepository->findID($user->user_id)->username); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
    </div>
<?php include __DIR__ . "/../../../layout/admin/footer.php"; ?>