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
                <input class="input-group mb-3" v-model="itemName" placeholder="Item Name...">
                <input class="input-group mb-3" v-model="itemDescription" placeholder="Add A Description...">
                <input class="input-group mb-3" v-model.number="itemCost" placeholder="Add Cost...">
                <select class="form-select" v-model.number="typeSelected">
                    <option disabled value="">Please select one</option>
                    <option v-for="t in master.type" v-bind:value="t.type_id"> {{ t.type}} </option>
                </select>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
                <div v-if="errors">
                    <div class='error' v-for="error in errors">
                        {{ error }}
                    </div>
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
                typeSelected: 0,
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

                // if this were live production I would have variables checking if anyone is logged in and an admin before letting this run

                this.errors = [];
                let answer = this.validate(this.itemName, this.itemDescription, this.itemCost, this.typeSelected);
                if (answer === false) {
                    return;
                }

                const data = { name: this.itemName, description: this.itemDescription, cost: this.itemCost, type: this.typeSelected }

                fetch('/vue_groceries_add.php', {
                    method: 'POST',
                    headers: {
                        'Content_type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })

                let master = this.master.type;
                let currentID = this.typeSelected;

                let i = master.length
                let newData = '';

                while (i--) {
                    if(currentID == master[i].type_id) {
                        newData = master[i].type;
                        break;
                    }
                }

                this.master.list.push({
                    name: this.itemName,
                    description: this.itemDescription,
                    cost: this.itemCost,
                    type: newData
                });

                this.itemName = '';
                this.itemDescription = '';
                this.itemCost = '';
                this.typeSelected = 0;

            },

            validate(itemName, itemDescription, itemCost, typeSelected) {

                if (itemName == null || itemName === "") {
                    this.errors.push("Name Field is invalid");
                }
                if (itemDescription == null || itemDescription === "") {
                    this.errors.push("Description Field is invalid");
                }
                if (itemCost === "" || typeof itemCost !== 'number') {
                    this.errors.push("Cost Field is not a number");
                }
                if (typeSelected === 0 || typeof typeSelected !== 'number') {
                    this.errors.push("Select Field is empty");
                }

                return this.errors.length === 0;
            }
        }
    }).mount('#app'); // .mount is mounting Vue to the selector so we can view it
</script>

<?php include "../../includes/footer.php" ?>