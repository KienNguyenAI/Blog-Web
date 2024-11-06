import PublicLayout from "../layout/public.vue";
import Test from "../pages/users/index.vue";

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
    }
]

export default publicRoutes;