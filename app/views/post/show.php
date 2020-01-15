<?php include __DIR__ . "/../layout/header.php"; ?>
    <br/>
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo escape($post->title); ?></h3>
                        <small>
                            posted <?php echo escape($post->created); ?> by
                            <a href="/app/index.php/user?id=<?php echo escape($post->user_id); ?>">
                            <?php echo escape($this->usersRepository->findID($post->user_id)->username); ?>
                            </a>
                            <?php if (isset($post->category_id)) {
                                echo " in <a href=\"/app/index.php/category?id=" . escape($post->category_id) . "\">" .
                                    escape($this->categoriesRepository->findID($post->category_id)->name)
                                    . "</a>";
                            } ?>
                        </small>
                    </div>
                    <div class="card-body">
                        <p><?php echo nl2br(escape($post->content)); ?></p>
                        <small class="float-md-right">last edited <?php echo escape($post->last_edit); ?></small>
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
                                    <?php echo escape($comment->content); ?><br/>
                                    <small>posted <?php echo escape($comment->created); ?> by
                                        <a href="/app/index.php/user?id=<?php echo escape($comment->user_id); ?>">
                                            <?php echo escape($this->usersRepository->findID($comment->user_id)->username); ?>
                                        </a></small>
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
                                               value="<?php echo escape($this->usersRepository->findUsername($_SESSION['login'])->id); ?>"
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