<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Post</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert alert-success">
        Post updated successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/posts/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Editing Post: <?php echo escape($entry->title); ?>
            </div>
            <div class="card-body">
                <input type="text" name="title" id="title" value="<?php echo escape($entry->title); ?>"
                       class="form-control" required/>
                <label class="control-label col-md-3" for="title">
                    Title
                </label>
                <select name="category_id" id="category_id"
                        class="form form-control col-md-4">
                    <option <?php
                            if (empty(escape($entry->category_id))) { echo "selected "; }
                            ?>value>
                        (None)
                    </option>
                    <?php foreach ($categories AS $category): ?>
                        <option value="<?php
                        echo escape($category->id);
                        ?>"<?php
                        if (escape($category->id) == escape($entry->category_id)) {
                            echo " selected";
                        } ?>>
                            <?php echo escape($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label class="control-label col-md-2" for="category_id">
                    Category
                </label>
                <textarea name="content" id="content" class="form-text form-control"
                          required><?php echo escape($entry->content); ?></textarea>
                <label class="control-label col-md-3" for="content">
                    Content
                </label>
                <br/>
                <button type="submit" name="save" id="save" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Save
                </button>
                <a href="/app/index.php/dashboard/posts/delete?id=<?php echo escape($entry->id); ?>"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>