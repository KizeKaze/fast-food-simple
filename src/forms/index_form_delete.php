<?php
//  I know this is not a good idea to copy/paste and shoe horn this to manipulate the dom
//  but for this small project it is just an example that I know the basics to dom manipulation

/**
 * @var \App\Classes\Cart $modifyCart
 * @var \App\Classes\Menu $menu
 */

require_once __DIR__ . '/../../php-config/init.php';
$User = new \App\Classes\User();

if (isset($_GET['add'])) {
    if (isset($_SESSION['user_role'])) {
        $query = new \App\Classes\Query();

        $item_id = sanitize($_GET['add']);
        $qty = sanitize($_GET['qty']);

        $modifyCart->checkQty($qty);
        $modifyCart->checkId($item_id);

        $params = [
            'item_id' => $item_id
        ];
        $result = $query->CustomSQL('SELECT * FROM item WHERE id = :item_id', $params);
        if (!count($result)) {
            $_SESSION['failure'] = 'What are you doing...';
            header('Location: /index.php');
            exit();
        }

        $params = [
                'item_id' => $item_id,
                'user_id' => $_SESSION['user_id']
        ];
        //check db for any items already in cart
        $result = $modifyCart->checkCart($params);
        if (count($result) >= 1) {
            //update instead of insert
            $params = [
                'user_id' => $_SESSION['user_id'],
                'item_id' => $item_id,
                'qty' => $qty
            ];

            $modifyCart->updateCart($params);
            $item_added = 'Item updated in shopping cart';
        } else {
            $params = [
                'user_id' => $_SESSION['user_id'],
                'item_id' => $item_id,
                'qty' => $qty
            ];

            $modifyCart->insertCart($params);
            $item_added = 'Item added to shopping cart';
        }
    }
}

//delete function
if (isset($_GET['id'])) {
    if ($User->isAdmin()) {

        $query = new \App\Classes\Query();
        $id = $_GET['id'];

        $params = [
            'id' => $id
        ];

        //check if any users have the item to be deleted in their shopping cart

        $result = $query->CustomSQL('SELECT COUNT(*) as amount from cart WHERE item_id = :id', $params);
        if ($result[0]['amount'] >= 1) {
            $errors[] = "Users have this item in their shopping cart, access denied. ID: " . $id;
        } else {
            $query->CustomSQL('DELETE FROM item WHERE id = :id', $params);
        }
    }
}

$search = null;
$type = null;

if (isset($_POST['submit']) || isset($_POST['type'])) {
    $type = trim(htmlspecialchars($_POST['type']));
    $search = trim(htmlspecialchars($_POST['search']));
}

$params = [
    'search' => $search,
    'type' => $type
];
$result = $menu->getItems($params);

if (empty($result)) {
    $errors[] = "<h4>Hmm... I couldn't find what you were looking for</h4>";
    include __DIR__ . "/../../templates/components/errors.php";
} else {
?>

    <div class="table-responsive">
        <table class="table table-light table-bordered table-hover table-responsive">
            <thead>
            <tr>
                <?php if ($User->isAdmin()) : ?>
                    <th class="hide_mobile_large">ID</th>
                <?php endif; ?>

                <th>Name</th>
                <th class="hide_mobile_large">Description</th>
                <th>Cost</th>
                <th class="hide_mobile_large">Type</th>

                <?php if ($User->isAdmin()) : ?>
                    <th colspan="2">Options</th>
                    <th>Quantity</th>
                <?php elseif ($User->loggedIn()) : ?>
                    <th>Quantity</th>
                <?php endif; ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($result as $row) : ?>
                <tr>
                    <?php if ($User->isAdmin()) : ?>
                        <td class="hide_mobile_large"><?= $row['id'] ?></td>
                    <?php endif; ?>

                    <td>
                        <a href="../../public/show_item_details.php?item=<?= $row['id'] ?>" class="text-decoration-none">
                            <?= $row['name'] ?>
                        </a>
                    </td>

                    <td class="hide_mobile_large">
                        <label for="description<?= $row['id'] ?>" class="visually-hidden">
                            Description
                        </label>
                        <textarea id="description<?= $row['id'] ?>" class="form-control" readonly><?= $row['description'] ?></textarea>
                    </td>

                    <td><?= $row['cost'] ?></td>
                    <td class="hide_mobile_large"><?= $row['type'] ?></td>

                    <?php if ($User->isAdmin()) : ?>
                        <td>
                            <a class="btn btn-primary" href="../../public/admin/edit_menu_item.php?edit=<?= $row['id'] ?>">Edit</a>
                        </td>

                        <td>
                            <form action="../../public/index.php" method="get">
                                <button type="submit" class="index_delete btn btn-danger" name="delete" value="<?= $row['id'] ?>">
                                    Delete
                                </button>
                            </form>
                        </td>

                        <td>
                            <form action="" method="get">
                                <label for="qty_<?= $row['id'] ?>" class="visually-hidden">
                                    Quantity
                                </label>
                                <select id="qty_<?= $row['id'] ?>" class="add_qty form-select" name="qty">
                                    <?php $menu->showQty(); ?>
                                </select>

                                <button class="index_qty btn btn-primary" value="<?= $row['id'] ?>" type="submit">
                                    Add
                                </button>
                            </form>
                        </td>

                    <?php elseif ($User->loggedIn()) : ?>

                        <td>
                            <form action="" method="get">
                                <label for="qty_<?= $row['id'] ?>" class="visually-hidden">
                                    Quantity
                                </label>
                                <select id="qty_<?= $row['id'] ?>" class="add_qty form-select" name="qty">
                                    <?php $menu->showQty(); ?>
                                </select>

                                <button class="index_qty btn btn-primary" value="<?= $row['id'] ?>" type="submit">
                                    Add
                                </button>
                            </form>
                        </td>

                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php } ?>
    </div>