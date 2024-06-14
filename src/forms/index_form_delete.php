<?php
//  I know this is not a good idea to copy/paste and shoe horn this to manipulate the dom
//  but for this small project it is just an example that I know the basics to dom manipulation
session_start();
require '../../vendor/autoload.php'; ?>
<?php
$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ . "\..\..");
$dotenv->load();
$menu = new \App\Classes\Menu();
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
        ];
        //check db for any items already in cart
        $result = $query->CustomSQL('SELECT * FROM cart WHERE item_id = :item_id', $params);
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
    $errors[] = "<h4>Hmm.. I couldn't find what you were looking for</h4>";
    include "../../includes/errors.php";
} else {
?>

<div class='container' id="main_card">
    <?php
        include "../../includes/errors.php";
    ?>
    <div class="table-responsive">
        <table class="table table-light table-bordered table-hover table-responsive">
            <thead>
            <?php if ($User->isAdmin()) : ?>
                <th>ID</th>
            <?php endif; ?>
            <th>Name</th>
            <th>Description</th>
            <th>Cost</th>
            <th>Type</th>
            <?php if ($User->isAdmin()) : ?>
                <th colspan="2">Options</th>
                <th>Quantity</th>
                <th>Cart</th>
            <?php elseif ($User->loggedIn()) : ?>
                <th>Quantity</th>
                <th>Cart</th>
            <?php endif; ?>
            </thead>
            <tbody>
            <tr>
                <?php foreach ($result as $row) {
                $id = $row['id'];
                $name = $row['name'];
                $description = $row['description'];
                $cost = $row['cost'];
                $type = $row['type'];
                ?>
                <?php if ($User->isAdmin()) : ?>
                    <td><?= $id ?></td>
                <?php endif; ?>
                <td><a href="../../show_item_details.php?item=<?= $id ?>" class="text-decoration-none"><?= $name ?></a></td>
                <td><textarea class="form-control" readonly><?= $description ?></textarea></td>
                <td><?= $cost ?></td>
                <td><?= $type ?></td>
                <?php if ($User->isAdmin()) : ?>
                    <td>
                        <a class="btn btn-primary" href="../../edit_menu_item.php?edit=<?= $id ?>">Edit</a>
                    </td>
                    <form action="../../index.php" method="get">
                        <td>
                            <button type="submit" class="btn btn-danger index_delete" name="delete" value="<?= $id ?>">
                                Delete
                            </button>
                        </td>
                    </form>
                    <form action="" method="get">
                        <td>
                            <select class="add_qty form-select" aria-label="Quantity select" name="qty">
                                <?php $menu->showQty(); ?>
                            </select>
                        </td>
                        <td>
                            <button class="index_qty btn btn-primary" value="<?= $id ?>" type="submit">Add</button>
                        </td>
                    </form>
                <?php elseif ($User->loggedIn()) : ?>
                    <form action="" method="get">
                        <td>
                            <select class="add_qty form-select" aria-label="Quantity select" name="qty">
                                <?php $menu->showQty(); ?>
                            </select>
                        </td>
                        <td>
                            <button class="index_qty btn btn-primary" value="<?= $id ?>" type="submit">Add</button>
                        </td>
                    </form>
                <?php endif; ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>