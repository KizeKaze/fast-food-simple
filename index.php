<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

<?php

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

