import PublicLayout from "../layout/public.vue";
import Main from "../pages/users/index.vue";
import topBlogs from "../pages/users/topBlogs.vue";
import category from "../components/TheCategory.vue";
import account from "../components/account/account.vue";
import setting from "../components/account/setting.vue";
import createPost from "../pages/users/post/createPost.vue";
// Login
import login from "../pages/auth/login.vue";
import register from "../pages/auth/register.vue";
import forgotPassword from "../pages/auth/forgotPassword.vue";
import createAccount from "../pages/auth/createAccount.vue";
import resetPassword from "../pages/auth/resetPassword.vue";
import { PiniaVuePlugin } from "pinia";
// ----------------------------------------


const publicRoutes = [
    {
        path: '/',
        component: PublicLayout,
        children: [
            {
                path: '',
                component: Main,
            },
            {
                path: 'top-blogs',
                component: topBlogs
            },
            {
                path: 'categories',
                component: category,
            },
            {
                path: '/account/:username',
                name: 'account',
                component: account,
            },
            {
                path: '/account/setting',
                component: setting,
            },

        ]
    },
    {
        path: '/post/write',
        component: createPost,
    },

    // Router to login
    {
        path: '/login',
        name: 'login',
        component: login,
    },
    {
        path: '/register',
        name: 'register',
        component: register,
    },

    {
        path: '/forgotPassword',
        name: 'forgot-password',
        component: forgotPassword
    },
    {
        path: '/createAccount',
        name: 'create-account',
        component: createAccount
    },
    {
        path: '/resetPassword',
        name: 'reset-password',
        component: resetPassword
    }
    // --------------------------------

]

export default publicRoutes;