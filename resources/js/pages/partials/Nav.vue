<template>
    <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
        <router-link v-if="!user" :to="{name: 'login'}">
            <img class="me-3" src="https://getbootstrap.com/docs/5.2/assets/brand/bootstrap-logo-white.svg" alt=""
                 width="48" height="38">
        </router-link>
        <router-link v-else :to="{name: 'dashboard'}">
            <img class="me-3" src="https://getbootstrap.com/docs/5.2/assets/brand/bootstrap-logo-white.svg" alt=""
                 width="48" height="38">
        </router-link>
        <div class="lh-1">
            <nav v-if="user" class="nav" aria-label="Secondary navigation">
                <router-link :to="{name: 'products'}" class="nav-link text-white">Products</router-link>
                <router-link :to="{name: 'carts'}" class="nav-link text-white">Carts ({{ cartsItemCount ?? 0 }} - ${{ cartsTotalAmount }})</router-link>
                <a href="javascript:void(0)" @click="logout" class="nav-link text-white">Logout</a>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.$store.dispatch('cartStore/cartItems');
    },
    computed: {
        user() {
            return this.$store.getters['authStore/user'];
        },
        cartsItemCount() {
            return this.$store.getters['cartStore/allCartItems']['items']?.length;
        },
        cartsTotalAmount() {
            return this.$store.getters['cartStore/allCartItems']['total'];
        }
    },
    methods: {
        async logout() {
            await this.$store.dispatch('authStore/logout');
            this.$router.push({name: 'login'});
        }
    }
}
</script>

<style>
.router-link-exact-active {
    color: black !important;
}
</style>
