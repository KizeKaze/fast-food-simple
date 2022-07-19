<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

    <!-- Including the Vue source code -->
    <script src="https://unpkg.com/vue@3"></script>

    <!-- Our Vue application -->
    <div id="app" class="vue-container">

    </div>

    <!-- Vue JS setup / mounting -->
    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                // Where the instance data is bound
                return {

                    ],
                }
            },
            // Where you put your methods; follow the convention from this test one to make a new function
            methods: {
                testMethod() {

                }
            }
        }).mount('#app'); // .mount is mounting Vue to the selector so we can view it
    </script>

<?php include "includes/footer.php" ?>