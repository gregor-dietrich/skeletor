<?php include __DIR__ . "/../../layout/admin/header.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Post</h1>
    </div>
<?php if (!empty($savedSuccess)): ?>
    <p>
        Post added successfully.
    </p>
<?php endif; ?>
    <div class="card">
        <form method="POST" action="/app/index.php/dashboard/posts/add" class="form-horizontal">
            <div class="card-header">
                <input type="text" name="title" id="title" value="" class="form-control" required/>
            </div>
            <div class="card-body">
                <textarea name="content" id="content" class="form-text form-control" required></textarea>
                <br/>
                <input type="submit" name="save" value="Save" id="save" class="btn btn-primary"/>
            </div>
        </form>
    </div>
<?php include __DIR__ . "/../../layout/admin/footer.php"; ?>