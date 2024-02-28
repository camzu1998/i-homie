import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router';
import {createBootstrap} from 'bootstrap-vue-next'
import routes from './routes';
import store from './store';
import App from './App.vue'

import './bootstrap.js';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    if (!to.meta.auth) {
        next();
    }
    axios.get('/api/user')
        .then(response => {
            if (response.data.isLogged) {
                next();
            } else {
                store.dispatch('removeAllUserData');
                next({ path: '/login' });
            }
        })
        .catch(error => {
            console.error(error);
        });
});

const app = createApp(App)

app.use(router);
app.use(store);
app.use(createBootstrap())

app.mount('#app');
