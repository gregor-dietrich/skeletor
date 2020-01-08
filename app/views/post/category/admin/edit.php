<?php include __DIR__ . "/../../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Post Category</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert alert-success">
        Post Category updated successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/post_categories/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Editing Post Category: <?php echo escape($entry->name); ?>
            </div>
            <div class="card-body">
                <input type="text" name="name" id="name" value="<?php echo escape($entry->name); ?>"
                       class="form form-control col-md-4" required/>
                <label class="control-label col-md-2" for="name">
                    Post Category Name
                </label>
                <select name="parent_id" id="parent_id"
                        class="form form-control col-md-4">
                    <option <?php
                                if (empty(escape($entry->parent_id))) { echo "selected "; }
                            ?>value>
                        (None)
                    </option>
                    <?php foreach ($categories AS $category):
                        if (escape($category->id) == escape($entry->id)) {
                            continue;
                        }
                        ?>
                        <option value="<?php
                                        echo escape($category->id);
                                        ?>"<?php
                                        if (escape($category->id) == escape($entry->parent_id)) {
                                            echo " selected";
                                        } ?>>
                            <?php echo escape($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label class="control-label col-md-2" for="parent_id">
                    Parent Category
                </label>
                <br/>
                <button type="submit" name="save" id="save" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Save
                </button>
                <a href="/app/index.php/dashboard/post_categories/delete?id=<?php echo escape($entry->id); ?>"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../../layout/admin/footer.php"; ?>