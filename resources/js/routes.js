import Home from "./Components/Home.vue";
import Register from "./Components/Auth/Register.vue";
import Profile from "./Components/User/Profile.vue";

export default [
    {
        path: '/',
        component: Home,
        name: 'Home',
        meta: {
            auth: true
        },
    },
    {
        path: '/',
        component: Home,
        name: 'Login',
        meta: {
            auth: false
        },
    },
    {
        path: '/register',
        component: Register,
        name: 'Register',
        meta: {
            auth: false
        },
    },
    {
        path: '/profile',
        component: Profile,
        name: 'Profile',
        meta: {
            auth: true
        },
    },
];
