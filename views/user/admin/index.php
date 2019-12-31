<?php include __DIR__ . "/../../layout/dashboard/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">All Users</h1>
    </div>
    <a class="btn btn-primary" href="/app/index.php/dashboard/users/add">
        Add New User
    </a>
    <br/><br/>
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
            <?php foreach ($users AS $user): ?>
                <tr>
                    <td><?php echo escape($user->id); ?></td>
                    <td>
                        <a href="/app/index.php/dashboard/users/edit?id=<?php echo escape($user->id); ?>"><?php echo escape($user->username); ?></a>
                    </td>
                    <td>
                        <a href="/app/index.php/dashboard/users/delete?id=<?php echo escape($user->id); ?>"
                           onclick="return confirm('Are you sure?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php include __DIR__ . "/../../layout/dashboard/footer.php"; ?>