<div class="container">
    <div class="row justify-content-center gx-0">
        <div class="card col-md-6">
            <div class="card-body">
                <?php include "includes/errors.php"; ?>
                <form action="" method="POST" class="form_index" enctype="multipart/form-data">
                    <input type="hidden" name="edit" value="<?= $item_id ?>">
                    <div>
                        <label class="input-group-addon" for="name"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-description">Name</span>
                            <input type="text" class="form-control" name="name" value='<?= $name ?>'>
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="description"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-description">Description</span>
                            <input id="description" name="description" type="text" class="form-control" value="<?= $description ?>">
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="cost"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-cost">$</span>
                            <input id="cost" name="cost" type="text" class="form-control" value="<?= $cost ?>">
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="type"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-select">Type</span>
                            <select class="form-select" name="type" id="type">
                                <?php
                                $types = $menu->getType();
                                $currentType = $type_id;
                                $select = "selected='selected'";
                                foreach ($types as $type) { ?>
                                    <?php if ($type['type_id'] == $currentType) { ?>
                                        <option <?=$select?> value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div id="content" class="input-group">
                        <input class="form-control" type="file" name="uploadfile" value="">
                    </div>
                    <div class="text-center">
                        <h4 id="image">Current database image</h4>
                    </div>
                    <div>
                        <img class="mx-auto d-block" src="src/images/<?= $image ?>" width="75%" height="300px" alt="item image">
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary" name="update" value=<?= $id ?>>Update</button>
                    <a href="/index.php" class="btn btn-danger">Go Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>