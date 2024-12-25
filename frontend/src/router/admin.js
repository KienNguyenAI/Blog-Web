import admin from "../layout/admin.vue"
import manageUser from "../admin/pages/user.vue";
import posts from "../admin/pages/post.vue";
import tags from "../admin/pages/tag.vue";
const adminRoutes = [
    {
        path: '/admin',
        component: admin,
        children: [
            {
                path: 'users',
                component: manageUser
            },
            {
                path: 'posts',
                component: posts
            },
            {
                path: 'tags',
                component: tags
            }
        ]
    }
]

export default adminRoutes;