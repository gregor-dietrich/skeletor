<?php include __DIR__ . "/../layout/header.php"; ?>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo escape($post->title); ?></h3>
                    </div>
                    <div class="card-body">
                        <?php echo nl2br(escape($post->content)); ?>
                    </div>
                </div>
                <br/>
                <div class="card">
                    <div class="card-header">
                        <h3>Comments</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <?php foreach ($comments AS $comment): ?>
                                <li class="list-group-item">
                                    <?php echo escape($comment->content, ENT_QUOTES, 'UTF-8'); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="container">
                        <div class="card">
                            <div class="card-header">
                                <h3>Add Comment</h3>
                            </div>
                            <div class="card-body">
                                <?php if (isset($_SESSION['login'])): ?>
                                    <form method="post" action="post?id=<?php echo escape($post->id); ?>">
                                        <input type="hidden" name="user_id" id="user_id"
                                               value="<?php echo $this->usersRepository->findUsername($_SESSION['login'])->id; ?>"
                                               required/>
                                        <textarea name="content" class="form-text form-control" required></textarea>
                                        <br/>
                                        <input type="submit" value="Add Comment" class="btn btn-primary"/>
                                    </form>
                                <?php else: ?>
                                    <p>Commenting is disabled because you're not logged in.
                                        <a href="login">Sign in</a> now.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include __DIR__ . "/../layout/footer.php"; ?>