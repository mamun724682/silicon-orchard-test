import {createStore} from 'vuex'
import authStore from "@/store/modules/authStore";
import cartStore from "@/store/modules/cartStore";


export default createStore({
    modules: {
        authStore,
        cartStore
    }
})
