<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

<?php
if (isset($_GET['add'])) {
    if (isset($_SESSION['user_role'])) {
        $query = new \App\Classes\Query();

        $item_id = sanitize($_GET['add']);
        $qty = sanitize($_GET['qty']);


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

            $query->insert('cart', $params);
            $item_added = 'Item added to shopping cart';
        }
    }
}

if (isset($_GET['delete'])) {
    if ($User->isAdmin()) {

        $id = $_GET['id'];

        $params = [
            'id' => $id
        ];

        $query = new \App\Classes\Query();
        $query->CustomSQL('DELETE FROM item WHERE id = :id', $params);
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

$User = new \App\Classes\User();

if (empty($result)) {
    $errors[] = "<h4>Hmm.. I couldn't find what you were looking for. <a href='/index.php' class='btn btn-primary'>Go Back</a></h4>";
}

include 'src/forms/index_form.php';


