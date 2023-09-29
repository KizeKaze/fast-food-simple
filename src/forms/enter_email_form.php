<div class="container">
    <div class="row justify-content-center gx-0">
        <div class="card col-sm-12 col-md-6">
            <div class="card-body">
                <?php include "includes/failure.php"; ?>
                <h5 class="card-title text-center align-middle">Reset password</h5>
                <hr>
                <form class="login-form" action="enter_email.php" method="post">
                    <!-- form validation messages -->
                    <div class="input-group">
                        <span class="input-group-text" id="email">Email</span>
                        <input id="email" name="email" type="email" class="form-control" />
                    </div>
                    <hr>
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary" name="reset-password">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>
