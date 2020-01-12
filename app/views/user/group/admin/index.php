<?php include __DIR__ . "/../../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All User Groups</h1>
        <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
           href="/app/index.php/dashboard/user_groups/add">
            <i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Group
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups AS $group): ?>
                <tr>
                    <td><?php echo escape($group->id); ?></td>
                    <td>
                        <a href="/app/index.php/dashboard/user_groups/edit?id=<?php echo escape($group->id); ?>"><?php echo escape($group->name); ?></a>
                    </td>
                    <td>
                        <a href="/app/index.php/dashboard/user_groups/edit?id=<?php echo escape($group->id); ?>"
                           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                        </a>
                        <a href="/app/index.php/dashboard/user_groups/delete?id=<?php echo escape($group->id); ?>"
                           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                           onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php include __DIR__ . "/../../../layout/admin/footer.php"; ?>