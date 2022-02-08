<?php $menu = new \App\Classes\Menu(); ?>
<html lang="en">
<head>
    <title>Fast Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="card" style="width: 32rem;">
        <div class="card-body" >
            <h5 class="card-title text-center align-middle">Add an item to the menu</h5>
            <hr>
            <form action="submit" method="post" class="form_index">
                <div>
                    <label class="input-group-addon" for="name"></label>
                    <span class="input-group-text" id="basic-addon-name">Item Name</span>
                    <div class="input-group">
                        <input id="name" name="name" type="text" class="form-control"/>
                    </div>
                </div>

                <div>
                    <label class="input-group-addon"  for="description"></label>
                    <span class="input-group-text" id="basic-addon-description">Description</span>
                    <div class="input-group">
                    <input id="description" name="description" type="text" class="form-control"/>
                    </div>
                </div>

                <div>
                    <label class="input-group-addon"  for="cost"></label>
                    <span class="input-group-text" id="basic-addon-cost">$</span>
                    <input id="cost" name="cost" type="text" class="form-control"/>
                </div>

                <div>
                    <label for="type" class="input-group-text">Type</label>
                    <select class="custom-select" name="value" id="type">
                        <?php

                        $types = $menu->getType();

                        foreach ($types as $type) { ?>
                            <option value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <br>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-check-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zm-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                    </svg>
                    Submit</button>
                <a href="menu_list.php" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                        <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Menu List</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>