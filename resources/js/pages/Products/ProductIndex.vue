<template>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between mb-2">
            <h6 class="border-bottom pb-2 mb-0">Products</h6>
            <router-link :to="{name: 'products_add'}" class="btn btn-primary btn-sm">Add New</router-link>
        </div>
        <div>
            <Vue3EasyDataTable
                v-model:server-options="serverOptions"
                :server-items-length="serverItemsLength"
                :headers="headers"
                :items="products"
                :loading="busy"
                show-index
            >
                <template #loading>
                    <img
                        src="https://i.pinimg.com/originals/94/fd/2b/94fd2bf50097ade743220761f41693d5.gif"
                        style="width: 100px; height: 80px;"
                    />
                </template>
                <template #item-id="item">
                    <button @click="addToCart(item.id)" class="btn btn-sm btn-warning">Add to cart</button>
                    <router-link :to="{ name: 'products_edit', params: { id: item.id }}" class="btn btn-sm btn-info mx-2">
                        Edit
                    </router-link>
                    <button @click="deleteProduct(item.id)" class="btn btn-sm btn-danger">Delete</button>
                </template>
            </Vue3EasyDataTable>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

export default {
    name: "Products",
    components: {
        Vue3EasyDataTable,
    },
    data() {
        return {
            headers: [
                {text: "name", value: "name"},
                {text: "Price", value: "price"},
                {text: "Actions", value: "id"},
            ],
            products: [],
            busy: false,
            serverItemsLength: 0,
            serverOptions: {
                page: 1,
                rowsPerPage: 15,
            }
        }
    },
    watch: {
        serverOptions: {
            handler() {
                this.getProducts()
            },
            deep: true
        }
    },
    mounted() {
        this.getProducts()
    },
    methods: {
        async getProducts() {
            try {
                this.busy = true
                await axios.get('/api/v1/products', { params: this.serverOptions })
                    .then(({data}) => {
                        this.products = data.data.data
                        this.serverItemsLength = data.data.meta.total
                    }).catch((err) => {
                        throw err.response
                    });
                this.busy = false
            } catch (e) {
                throw e
            }
        },
        async deleteProduct(id) {
            try {
                this.busy = true
                await axios.delete('/api/v1/products/' + id)
                    .then(({data}) => {
                        this.getProducts();
                        this.$store.dispatch('cartStore/cartItems');
                    }).catch((err) => {
                        throw err.response
                    });
                this.busy = false
            } catch (e) {
                throw e
            }
        },
        addToCart(product_id) {
            this.$store.dispatch('cartStore/addToCart', {
                'product_id': product_id
            })
        }
    },
}
</script>

<style scoped>

</style>
