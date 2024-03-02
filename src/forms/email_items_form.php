<html>
    <header>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    </header>
    <body>
    <div class='card'>
        <div class='card-header'>
            Purchased Items
        </div>
        <div class='card-body'>
            <h5 class='card-title'>Here is an itemized list of your purchased items</h5>
            <table class='table'>
                <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Product</th>
                    <th scope='col'>Price ea</th>
                    <th scope='col'>Quantity</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($email_items as $element) : ?>
                    <tr>
                        <th scope='row'><?= $i ?></th>
                        <td><?= $element['item_name'] ?></td>
                        <td><?= $element['cost'] ?></td>
                        <td>x <?= $element['qty'] ?></td>
                        <?php $i++ ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class='card-footer text-muted'>
            Items purchased on <?=$order_details[0]['formatted_date'] ?> for a total of $<?=$order_details[0]['grand_total'] ?>
        </div>
    </div>
    </body>
</html>
