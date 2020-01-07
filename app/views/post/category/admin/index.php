<?php include __DIR__ . "/../../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Post Categories</h1>
        <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="/app/index.php/dashboard/post_categories/add">
            <i class="fas fa-plus-circle fa-sm text-white-50"></i> Add New Post Category
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Parent Category</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories AS $category): ?>
                <tr>
                    <td><?php echo escape($category->id); ?></td>
                    <td><?php if (!empty($category->parent_id)) {
                            echo escape($this->categoriesRepository->findID($category->parent_id)->name);
                        }?></td>
                    <td>
                        <a href="/app/index.php/dashboard/post_categories/edit?id=<?php echo escape($category->id); ?>">
                            <?php echo escape($category->name); ?>
                        </a>
                    </td>
                    <td>
                        <a href="/app/index.php/dashboard/post_categories/edit?id=<?php echo escape($category->id); ?>"
                           class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-edit fa-sm text-white-50"></i> Edit
                        </a>
                        <a href="/app/index.php/dashboard/post_categories/delete?id=<?php echo escape($category->id); ?>"
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