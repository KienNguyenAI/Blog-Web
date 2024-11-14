import PublicLayout from "../layout/public.vue";
import topBlogs from "../pages/users/topBlogs.vue";
// Login
import login from "../pages/auth/login.vue";
import signup from "../pages/auth/signup.vue";
import forgotPassword from "../pages/auth/forgotPassword.vue";
import createAccount from "../pages/auth/createAccount.vue";
import resetPassword from "../pages/auth/resetPassword.vue";
// ----------------------------------------


const publicRoutes = [
    {
        path: '/',
        component: PublicLayout,
    },
    // Router to login
    {
        path: '/login',
        name: 'login',
        component: login,
    },
    {
        path: '/signup',
        name: 'sign-up',
        component: signup,
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