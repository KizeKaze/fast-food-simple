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
                        <span class="input-group-text" id="password">New Password</span>
                        <input id="password" name="password" type="password" class="form-control" />
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="confirm_password">Confirm New Password</span>
                        <input id="confirm_password" name="confirm_password" type="password" class="form-control" />
                    </div>
                    <hr>
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary" name="new_password">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>
