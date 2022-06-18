<?php if(isset($_GET['edit'])) : ?>
    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1) : ?>
    <?php
        $type = sanitize($_GET['edit']);
        $id = sanitize($_GET['id']);
    ?>
            <div class="col-sm-12 col-md-12">
                <form action="types.php" method="post">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="edit_type">Edit Type</span>
                        <input type="hidden" name="id" value="<?= $id ?>" >
                        <input class="form-control" type="text" name="type_edit" value="<?= $type ?>">
                        <button class="btn btn-success">Edit</button>
                    </div>
                </form>
            </div>
    <?php endif; ?>
<?php endif; ?>
