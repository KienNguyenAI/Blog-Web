import PublicLayout from "../layout/public.vue";
import Test from "../pages/users/index.vue";
import login from "../pages/auth/login.vue";
import signup from "../pages/auth/signup.vue";
import forgotPassword from "../pages/auth/forgotPassword.vue";

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
    {
        path: '/login',
        name: 'login',
        component: login,
    },
    {
        path: '/signup',
        name: 'signup',
        component: signup,
    },
    {
        path: '/forgotPassword',
        name: 'forgotPassword',
        component: forgotPassword
    }

]

export default publicRoutes;