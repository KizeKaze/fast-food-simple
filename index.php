<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

<?php
    if(isset($_GET['delete'])){
        if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1){
            $id = $_GET['delete'];

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

    if (empty($result)) {
        $errors[] = "<h4>Hmm.. I couldn't find what you were looking for</h4>";
    }

    include 'src/forms/index_form.php';
?>

