import PublicLayout from "../layout/public.vue";
import Test from "../pages/users/index.vue";

// Login
import login from "../pages/auth/login.vue";
import signup from "../pages/auth/signup.vue";
import forgotPassword from "../pages/auth/forgotPassword.vue";
import createAccount from "../pages/auth/createAccount.vue";
import resetPassword from "../pages/auth/resetPassword.vue";
// ----------------------------------------

const publicRoutes = [
    {
        path: '/user',
        component: PublicLayout,
        children: [
            {
                path: 'test',
                name: "user-test",
                component: Test,
            }
        ]
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