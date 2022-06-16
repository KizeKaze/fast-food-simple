<div class="container">
    <div class="row justify-content-center">
        <div class="card w-50">
            <div class="card-body">
                <?php
                include "includes/errors.php";
                include "includes/success.php";
                ?>
                <h5 class="card-title text-center align-middle">Create an account today!</h5>
                <hr>
                <form action="" method="post" class="form_index">
                    <div>
                        <label class="input-group-addon" for="username"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="email">Username</span>
                            <input id="username" name="username" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="email"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="email">Email</span>
                            <input id="email" name="email" type="email" class="form-control"/>
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="password"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="password">Password</span>
                            <input id="password" name="password" type="password" class="form-control"/>
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="confirm_password"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="confirm_password">Confirm Password</span>
                            <input id="confirm_password" name="confirm_password" type="password" class="form-control"/>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-bag-check-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                  d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zm-.646 5.354a.5.5 0 0 0-.708-.708L7.5 10.793 6.354 9.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                        </svg>
                        Create Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php" ?>