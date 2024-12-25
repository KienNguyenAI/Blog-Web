import { createRouter, createWebHistory } from "vue-router";
import users from "./public";
import adminForm from "./admin";

const routes = [
    ...users,
    ...adminForm,
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


export default router;


