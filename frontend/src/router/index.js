import { createRouter, createWebHistory } from "vue-router";
import users from "./public";
import account from "./account.js";

const routes = [
    ...users,
    ...account
];

const router = createRouter({
    history: createWebHistory(),
    routes
});


export default router;


