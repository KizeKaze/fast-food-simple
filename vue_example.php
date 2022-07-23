<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

    <!-- Including the Vue source code -->
    <script src="https://unpkg.com/vue@3"></script>

    <!-- Our Vue application -->
    <div id="app" class="vue-container">
        <div v-if="errors">
            <div v-for="error in errors">
                {{ error }}
            </div>
        </div>
        <ul>
            <li v-for="item in cart">
                {{ item.id }},
                {{ item.name }},
                {{ item.cost }}
            </li>
        </ul>
        <form @submit.prevent="add">
            <input v-model="addItem" placeholder="Add An Item...">
            <input v-model="addCost" placeholder="Add Cost...">
            <button type="submit">Add</button>
        </form>
    </div>

    <!-- Vue JS setup / mounting -->
    <script>
		const { createApp } = Vue;
		
		createApp({
			data() {
				// Where the instance data is bound
				return {
				    cart: [
                        { id: 1, name: 'Milk', cost: 2.99},
                        { id: 2, name: 'Bread', cost: .99},
                        { id: 3, name: 'Coffee', cost: 3.99},
                        { id: 15, name: 'creamer', cost: 3.99}
                    ],

                    addItem: '',
                    addCost: '',
                    errors: []
				}
			},
            // Where you put your methods; follow the convention from this test one to make a new function
			methods: {
				testMethod() {
                    this.addItem = ''
                    this.addCost = ''
                    this.errors = []
                },

                add() {
                    this.errors = [];
                    let answer = this.validate(this.addItem, this.addCost);
                    if (answer === false) {
                        return;
                    }
                    const ids = this.cart.map(object => {
                        return object.id;
                    });

                    let max = Math.max(...ids)
                    this.cart.push({
                        id: max + 1,
                        name: this.addItem,
                        cost: this.addCost

                    });
                    this.testMethod();
                },

                validate(name, cost) {

                    if (name == null || name === "") {
                        this.errors.push("Name is empty");
                    }
                    if (cost == null || cost === "") {
                        this.errors.push("Cost is empty");
                    }
                    return this.errors.length === 0;
                }
			}
		}).mount('#app'); // .mount is mounting Vue to the selector so we can view it
    </script>

<?php include "includes/footer.php" ?>