<?php include "../../includes/header.php"; ?>
<?php include "../../includes/nav.php" ?>

<!-- Including the Vue source code -->
<script src="https://unpkg.com/vue@3"></script>

<!-- Our Vue application -->
<div id="app" class="container">
    <div class="card">
        <div class="card-header">
            Vue Groceries List
        </div>
        <div class="card-body">
            <h5 class="card-title">The Big Vue</h5>
            <p class="card-text">Hey, this Vue Groceries is powered by Vue and this is just a
            super simple example of my knowledge in it. Feel free to add items to demonstrate!</p>
            <div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header text-center">
            Add An Item
        </div>
        <div class="card-body text-center">
            <form @submit.prevent="addGroceries">
                <input v-model="itemName" placeholder="Item Name...">
                <input v-model="itemDescription" placeholder="Add A Description...">
                <input v-model.number="itemCost" placeholder="Add Cost...">
                <select v-model.number="selected">
                    <option disabled value="">Please select one</option>
                    we have the type_id, on submit loop thourh master.type and find a match with the type_id and grab the name with it
                    <option v-for="t in master.type" v-bind:value="t.type_id"> {{ t.type}} </option>
                </select>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
            <div>

            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-light table-bordered table hover table-responsive">
            <thead>
                <th>Name</th>
                <th>Description</th>
                <th>Cost</th>
                <th>Type</th>
            </thead>
            <tbody>
                <tr v-for="list in master.list">
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
               master: [],

                itemName: '',
                itemDescription: '',
                itemCost: '',
                selected: '',
                errors: []
            }
        },
        mounted() {
            // => in this usage it is shorthand for .then(function(response){ return response.json()})
            fetch('/vue_groceries.php')
                .then(response => response.json())
                .then(data => this.master = data);
        },
        // Where you put your methods; follow the convention from this test one to make a new function
        methods: {

            addGroceries() {

                this.errors = [];
                let answer = this.validate(this.itemName, this.itemDescription, this.itemCost);
                console.log(answer);
                if (answer === false) {
                    alert('One of the fields is incorrect');
                    return;
                }
                alert('pretend I pushed this into the db ahaha!');


                let needle = this.selected;

                console.log(this.master.type);

                console.log(this.selected);
                this.master.list.push({
                    name: this.itemName,
                    description: this.itemDescription,
                    cost: this.itemCost,
                    type: this.selected
                });

                this.name = '';
                this.description = '';
                this.cost = '';
                this.type = '';

            },

            validate(itemName, itemDescription, itemCost) {

                if (itemName == null || itemName === "") {
                    this.errors.push("Name Field is invalid");
                }
                if (itemDescription == null || itemDescription === "") {
                    this.errors.push("Description Field is invalid");
                }
                if (itemCost === "" || typeof itemCost !== 'number') {
                    console.log(typeof itemCost);
                    this.errors.push("Cost Field is not a number");
                }

                return this.errors.length === 0;
            }
        }
    }).mount('#app'); // .mount is mounting Vue to the selector so we can view it
</script>

<?php include "../../includes/footer.php" ?>