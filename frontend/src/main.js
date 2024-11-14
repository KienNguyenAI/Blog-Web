import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router/index.js';
import './style.css';
import App from './App.vue';
import axios from 'axios';
window.axios = axios;

import '@fortawesome/fontawesome-free/css/all.min.css';
import 'ant-design-vue/dist/reset.css';
import "bootstrap/dist/css/bootstrap-grid.min.css";
import "bootstrap/dist/css/bootstrap-utilities.min.css";
import Antd from 'ant-design-vue';

router.beforeEach((to, from, next) => {
    if (to.path === '/' && !to.query.sort && !to.query.page_idx) {
        next({ path: '/', query: { sort: 'hot' } });
    } else {
        next();
    }
});

const app = createApp(App);

app.use(Antd);
app.use(router);
app.mount('#app');
