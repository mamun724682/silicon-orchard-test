<template>
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h6 class="border-bottom pb-2 mb-0">Edit Product</h6>

        <Errors type="danger" v-if="errors" :content="errors" @close="errors=null"/>

        <form @submit.prevent="updateProduct">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="form_data.name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="any" v-model="form_data.price" class="form-control" id="price">
            </div>
            <button type="submit" class="btn btn-primary" :disabled="busy"
                    v-text="busy ? 'Loading...' : 'Save'"></button>
        </form>
    </div>
</template>

<script>
import Errors from "@/components/Errors.vue";
import axios from "axios";

export default {
    components: {
        Errors
    },
    data() {
        return {
            product: null,
            form_data: {
                name: '',
                price: null
            },
            errors: null,
            busy: false,
        }
    },
    mounted() {
        this.getSingleProduct()
    },
    methods: {
        async getSingleProduct() {
            try {
                this.busy = true
                await axios.get('/api/v1/products/' + this.$route.params.id, { params: this.serverOptions })
                    .then(({data}) => {
                        this.form_data.name = data.data?.name
                        this.form_data.price = data.data?.price
                    }).catch((err) => {
                        throw err.response
                    });
                this.busy = false
            } catch (e) {
                throw e
            }
        },
        async updateProduct() {
            this.busy = true;
            this.errors = null

            await axios.put('/api/v1/products/' + this.$route.params.id, this.form_data)
                .then(({data}) => {
                    if (data.success === true) {
                        this.$router.push({name: 'products'})
                    }
                }).catch((err) => {
                    this.errors = err.response.data
                });

            this.busy = false;
        }
    }
}
</script>

<style scoped>

</style>
