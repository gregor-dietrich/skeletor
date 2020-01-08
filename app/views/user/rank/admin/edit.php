<?php include __DIR__ . "/../../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User Rank</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert alert-success">
        User Rank updated successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/user_ranks/edit?id=<?php echo escape($entry->id); ?>"
              class="form-horizontal">
            <div class="card-header">
                Editing User Rank: <?php echo escape($entry->name); ?>
            </div>
            <div class="card-body">
                <input type="text" name="name" id="name" value="<?php echo escape($entry->name); ?>"
                       class="form form-control col-md-4" required/>
                <label class="control-label col-md-2" for="name">
                    User Rank Name
                </label>
                <div class="container-fluid">
                    <input class="form-check-input" type="checkbox" name="post_add" id="post_add"
                           value="1"<?php if (escape($entry->post_add) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_add">
                        Add Posts
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_delete" id="post_delete"
                           value="1"<?php if (escape($entry->post_delete) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_delete">
                        Delete Posts
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_edit" id="post_edit"
                           value="1"<?php if (escape($entry->post_edit) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_edit">
                        Edit Posts
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="post_category_add" id="post_category_add"
                           value="1"<?php if (escape($entry->post_category_add) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_category_add">
                        Add Post Categories
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_category_delete"
                           id="post_category_delete" value="1"<?php if (escape($entry->post_category_delete) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_category_delete">
                        Delete Post Categories
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_category_edit" id="post_category_edit"
                           value="1"<?php if (escape($entry->post_category_edit) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_category_edit">
                        Edit Post Categories
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="post_comment_add" id="post_comment_add"
                           value="1"<?php if (escape($entry->post_comment_add) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_comment_add">
                        Add Post Comments
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_comment_delete" id="post_comment_delete"
                           value="1"<?php if (escape($entry->post_comment_delete) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_comment_delete">
                        Delete Post Comments
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_comment_edit" id="post_comment_edit"
                           value="1"<?php if (escape($entry->post_comment_edit) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="post_comment_edit">
                        Edit Post Comments
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="user_add" id="user_add"
                           value="1"<?php if (escape($entry->user_add) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="user_add">
                        Add Users
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_delete" id="user_delete"
                           value="1"<?php if (escape($entry->user_delete) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="user_delete">
                        Delete Users
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_edit" id="user_edit"
                           value="1"<?php if (escape($entry->user_edit) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="user_edit">
                        Edit Users
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="user_rank_add" id="user_rank_add"
                           value="1"<?php if (escape($entry->user_rank_add) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="user_rank_add">
                        Add User Ranks
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_rank_delete" id="user_rank_delete"
                           value="1"<?php if (escape($entry->user_rank_delete) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="user_rank_delete">
                        Delete User Ranks
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_rank_edit" id="user_rank_edit"
                           value="1"<?php if (escape($entry->user_rank_edit) == 1) {
                        echo " checked";
                    } ?>/>
                    <label class="form-check-label col-md-2" for="user_rank_edit">
                        Edit User Ranks
                    </label>
                </div>
                <br/>
                <button type="submit" name="save" id="save"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-edit fa-sm text-white-50"></i> Save
                </button>
                <a href="/app/index.php/dashboard/user_ranks/delete?id=<?php echo escape($entry->id); ?>"
                   class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
                   onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash-alt fa-sm text-white-50"></i> Delete</a>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../../layout/admin/footer.php"; ?>