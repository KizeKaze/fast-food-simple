<div class="container">
    <div class="row justify-content-center gx-0">
        <div class="card col-sm-12 col-md-6">
            <div class="card-body">
                <h5 class="card-title text-center align-middle">Password Reset</h5>
                <hr>
                <form class="login-form" action="enter_email.php" method="post">
                    <div class="input-group">
                        <p>
                            An email will be shortly sent to  <b><?php echo $_GET['email'] ?></b> to help you recover your account.
                        </p>
                        <p>
                            Please login into your email account and click on the link we sent to reset your password
                        </p>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>
