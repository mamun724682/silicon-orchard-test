import axios from 'axios';
import sharedMutations from 'vuex-shared-mutations';

export default {
    namespaced: true,
    state() {
        return {
            cartItems: []
        }
    },
    getters: {
        allCartItems(state) {
            return state.cartItems;
        }
    },
    mutations: {
        setCartItems(state, payload) {
            state.cartItems = payload;
        }
    },

    actions: {
        async cartItems({commit}) {
            // axios.defaults.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
            await axios.get('/api/v1/cart-items')
                .then(({data}) => {
                    commit('setCartItems', data.data);
                }).catch(({response}) => {
                    commit('setCartItems', []);
                    // throw response
                })
        },
        async addToCart({dispatch}, payload) {
            try {
                await axios.post('/api/v1/add-to-cart', payload)
                    .then(() => dispatch('cartItems'))
                    .catch((err) => {
                        throw err.response
                    });
            } catch (e) {
                throw e
            }
        },

        async setQuantity({dispatch}, payload) {
            try {
                await axios.post('/api/v1/cart-item-quantity-set/' + payload.index, payload)
                    .then(() => dispatch('cartItems'))
                    .catch((err) => {
                        throw err.response
                    });
            } catch (e) {
                throw (e)
            }
        },

        async incrementQuantity({dispatch}, payload) {
            try {
                await axios.post('/api/v1/increment-cart-item/' + payload)
                    .then(() => dispatch('cartItems'))
                    .catch((err) => {
                        throw err.response
                    });
            } catch (e) {
                throw (e)
            }
        },

        async decrementQuantity({dispatch}, payload) {
            try {
                await axios.post('/api/v1/decrement-cart-item/' + payload)
                    .then(() => dispatch('cartItems'))
                    .catch((err) => {
                        throw err.response
                    });
            } catch (e) {
                throw (e)
            }
        },

        async removeFromCart({dispatch}, payload) {
            try {
                await axios.delete('/api/v1/remove-from-cart/' + payload)
                    .then(() => dispatch('cartItems'))
                    .catch((err) => {
                        throw err.response
                    });
            } catch (e) {
                throw (e)
            }
        },

        async clearCart({dispatch}) {
            try {
                await axios.delete('/api/v1/clear-cart')
                    .then(() => dispatch('cartItems'))
                    .catch((err) => {
                        throw err.response
                    });
            } catch (e) {
                throw (e)
            }
        }
    },
    plugins: [sharedMutations({predicate: ['setCartItems']})],
}
