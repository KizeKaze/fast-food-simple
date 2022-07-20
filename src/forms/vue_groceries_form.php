<?php include "../../includes/header.php"; ?>
<?php include "../../includes/nav.php" ?>

<!-- Including the Vue source code -->
<script src="https://unpkg.com/vue@3"></script>

<!-- Our Vue application -->
<div id="app" class="container">
    <div class="table-responsive">
        <table class="table table-light table-bordered table hover table-responsive">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Cost</th>
                <th>Type</th>
            </thead>
            <tbody>
                <tr v-for="list in lists">
                    <td> {{ list.name }} </td>
                    <td> {{ list.description }} </td>
                    <td> {{ list.cost }} </td>
                    <td> {{ list.type }} </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Vue JS setup / mounting -->
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            // Where the instance data is bound
            return {
                lists: []

            }
        },
        mounted() {
            // => in this usage it is shorthand for .then(function(response){ return response.json()})
            fetch('/vue_groceries.php')
                .then(response => response.json())
                .then(data => this.lists = data);

        },
        // Where you put your methods; follow the convention from this test one to make a new function
        methods: {
            testMethod() {

            }
        }
    }).mount('#app'); // .mount is mounting Vue to the selector so we can view it
</script>

<?php include "../../includes/footer.php" ?>