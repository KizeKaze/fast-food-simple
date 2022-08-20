<?php include "includes/header.php" ?>
<?php include "includes/nav.php" ?>
<?php
if (isset($item_added)) {
    $item_added = 'Item added!';
}
?>
<div class="container">
    <div class="row justify-content-center gx-0">
        <div class="card col-sm-6">
            <div class="card-body">
                <?php
                    include "includes/errors.php";
                    include "includes/success.php";
                ?>
                <h5 class="card-title text-center align-middle">Add an item to the menu</h5>
                <hr>
                <form action="" method="post" class="form_index">
                    <div>
                        <label class="input-group-addon" for="name"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-name">Item Name</span>
                            <input id="name" name="name" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="description"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-description">Description</span>
                            <input id="description" name="description" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="cost"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-cost">$</span>
                            <input id="cost" name="cost" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="type"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-select">Type</span>
                            <select class="form-select" name="value" id="type">
                                <?php

                                $types = $menu->getType();

                                foreach ($types as $type) { ?>
                                    <option value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-bag-check-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zm-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                        </svg>
                        Submit
                    </button>
                    <a href="/index.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php" ?>