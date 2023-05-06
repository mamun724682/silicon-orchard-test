<template>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between">
            <h6 class="border-bottom pb-2 mb-0">Cart Items</h6>
            <button class="btn btn-sm btn-danger" @click="$store.dispatch('cartStore/clearCart')">Checkout</button>
        </div>
        <div class="d-flex justify-content-between text-muted pt-3 border-bottom" v-for="(item, key) in cartsItems?.items" :key="key">
            <p class="pb-3 mb-0 small lh-sm">
                <strong class="d-block text-gray-dark">{{ item.name }}</strong>
                <span>Price: {{ item.price }}</span> <br>
                <span>Quantity: {{ item.quantity }}</span>
            </p>
            <div class="align-self-center">
                <label for="qqq" class="form-label">Quantity</label>
                <button class="btn btn-sm btn-success mx-2" @click="$store.dispatch('cartStore/incrementQuantity', key)">+</button>
                <input type="number" min="0" class="w-25" :id="key" @input="setQuantity" :value="item.quantity">
                <button class="btn btn-sm btn-warning mx-2" @click="$store.dispatch('cartStore/decrementQuantity', key)">-</button>
            </div>

            <div>
                <button class="btn btn-sm btn-danger" @click="$store.dispatch('cartStore/removeFromCart', key)">X</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Carts",
    data() {
        return {
            quantity: 0
        }
    },
    computed: {
        cartsItems() {
            return this.$store.getters['cartStore/allCartItems'];
        },
    },
    methods: {
        setQuantity(event) {
            this.$store.dispatch('cartStore/setQuantity', {
                index: event.currentTarget.id,
                quantity: event.currentTarget.value
            })
        }
    },
}
</script>

<style scoped>

</style>
