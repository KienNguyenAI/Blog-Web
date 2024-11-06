import { createRouter, createWebHistory } from "vue-router";
import users from "./public";

const routes = [
    ...users,
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


export default router;


