import Login from "@/pages/auth/Login.vue";
import Register from "@/pages/auth/Register.vue";
import Dashboard from "@/pages/Dashboard.vue";
import NotFound from "@/pages/NotFound.vue";
import ProductIndex from "@/pages/Products/ProductIndex.vue";
import ProductCreate from "@/pages/Products/ProductCreate.vue";
import Carts from "@/pages/Carts.vue";
import ProductEdit from "@/pages/Products/ProductEdit.vue";

export default [
    {
        path: '/',
        component: Login,
        name: 'login',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/register',
        component: Register,
        name: 'register',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: 'dashboard',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/products',
        component: ProductIndex,
        name: 'products',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/products/add',
        component: ProductCreate,
        name: 'products_add',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/products/:id/edit',
        component: ProductEdit,
        name: 'products_edit',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/carts',
        component: Carts,
        name: 'carts',
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notfound',
        component: NotFound,
        meta: {
            guard: 'guest'
        }
    }
];
