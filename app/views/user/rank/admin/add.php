<?php include __DIR__ . "/../../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add User Rank</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert alert-success">
        User Rank added successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/user_ranks/add" class="form-horizontal">
            <div class="card-header">
                New User Rank
            </div>
            <div class="card-body">
                <input type="text" name="name" id="name" value=""
                       class="form form-control col-md-4" required/>
                <label class="control-label col-md-2" for="name">
                    User Rank Name
                </label>
                <div class="container-fluid">
                    <input class="form-check-input" type="checkbox" name="post_add" id="post_add" value="1"/>
                    <label class="form-check-label col-md-3" for="post_add">
                        Add Posts
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_delete" id="post_delete" value="1"/>
                    <label class="form-check-label col-md-3" for="post_delete">
                        Delete Posts
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_edit" id="post_edit" value="1"/>
                    <label class="form-check-label col-md-3" for="post_edit">
                        Edit Posts
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="post_category_add" id="post_category_add"
                           value="1"/>
                    <label class="form-check-label col-md-3" for="post_category_add">
                        Add Post Categories
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_category_delete"
                           id="post_category_delete" value="1"/>
                    <label class="form-check-label col-md-3" for="post_category_delete">
                        Delete Post Categories
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_category_edit" id="post_category_edit"
                           value="1"/>
                    <label class="form-check-label col-md-3" for="post_category_edit">
                        Edit Post Categories
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="post_comment_add" id="post_comment_add"
                           value="1"/>
                    <label class="form-check-label col-md-3" for="post_comment_add">
                        Add Post Comments
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_comment_delete" id="post_comment_delete"
                           value="1"/>
                    <label class="form-check-label col-md-3" for="post_comment_delete">
                        Delete Post Comments
                    </label>
                    <input class="form-check-input" type="checkbox" name="post_comment_edit" id="post_comment_edit"
                           value="1"/>
                    <label class="form-check-label col-md-3" for="post_comment_edit">
                        Edit Post Comments
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="user_add" id="user_add" value="1"/>
                    <label class="form-check-label col-md-3" for="user_add">
                        Add Users
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_delete" id="user_delete" value="1"/>
                    <label class="form-check-label col-md-3" for="user_delete">
                        Delete Users
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_edit" id="user_edit" value="1"/>
                    <label class="form-check-label col-md-3" for="user_edit">
                        Edit Users
                    </label>
                    <br/>
                    <input class="form-check-input" type="checkbox" name="user_rank_add" id="user_rank_add" value="1"/>
                    <label class="form-check-label col-md-3" for="user_rank_add">
                        Add User Ranks
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_rank_delete" id="user_rank_delete"
                           value="1"/>
                    <label class="form-check-label col-md-3" for="user_rank_delete">
                        Delete User Ranks
                    </label>
                    <input class="form-check-input" type="checkbox" name="user_rank_edit" id="user_rank_edit"
                           value="1"/>
                    <label class="form-check-label col-md-3" for="user_rank_edit">
                        Edit User Ranks
                    </label>
                </div>
                <br/>
                <button type="submit" name="save" id="save"
                        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Save
                </button>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../../layout/admin/footer.php"; ?>