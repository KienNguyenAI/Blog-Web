import { createApp, onMounted } from 'vue'
import { createPinia } from 'pinia';
import router from './router/index.js';
import './style.css'
import App from './App.vue'

import axios from 'axios';
window.axios = axios;

// import './satics/fontawesome/css/all.min.css';
import 'ant-design-vue/dist/reset.css';
import "bootstrap/dist/css/bootstrap-grid.min.css";
import "bootstrap/dist/css/bootstrap-utilities.min.css";

import {

} from 'ant-design-vue';



const app = createApp(App);
// app.use(createPinia());
app.use(router);
app.mount('#app');
