<div class='container'>
    <div class="row justify-content-center">
        <div class="card col-sm-6">
            <div class="card-body">
                <?php include "includes/errors.php"; ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <form action="" method="GET">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon-type">Add Type</span>
                                <input class="form-control" type="text" name="add">
                                <button class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                    <?php if(isset($_GET['edit'])) : ?>
                        <?php include 'src/forms/type_edit_form.php' ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="card col-sm-6">
            <div class="table-responsive">
                <table class="table table-light table-bordered table-hover table-responsive table-sm">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th >Type</th>
                        <th colspan="2">Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php foreach ($types as $type) {
                        $id = $type['type_id'];
                        $type = $type['type'];
                        ?>
                        <td><?= $id ?></td>
                        <td><?= $type ?></td>
                        <form action="" method="get">
                            <td>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" class="btn btn-primary" name="edit" value=<?= $type ?>>Edit</button>
                            </td>
                        </form>
                        <form action="" method="get">
                            <td>
                                <button type="submit" class="btn btn-danger" name="delete" value=<?= $id ?>>Delete</button>
                            </td>
                        </form>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>