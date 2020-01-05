<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Post</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p class="alert-success">
        Post added successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/posts/add" class="form-horizontal">
            <div class="card-header">
                New Post
            </div>
            <div class="card-body">
                <input type="text" name="title" id="title" value="" class="form-control" required/>
                <label class="control-label col-md-3" for="title">
                    Title
                </label>
                <textarea name="content" id="content" class="form-text form-control" required></textarea>
                <label class="control-label col-md-3" for="content">
                    Content
                </label>
                <br/>
                <button type="submit" name="save" id="save" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus-circle fa-sm text-white-50"></i> Save
                </button>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>