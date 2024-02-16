import Home from "./Components/Home.vue";
import Register from "./Components/Auth/Register.vue";
import Profile from "./Components/User/Profile.vue";
import LeftSidebar from "./Components/Partials/Menu/LeftSidebar.vue";
import LoginForm from "./Components/Auth/LoginForm.vue";

export default [
    {
        path: '/',
        components: {
            default: Home,
            LeftSidebar,
        },
        name: 'Home',
        meta: {
            auth: true
        },
    },
    {
        path: '/login',
        components: {
            default: LoginForm,
        },
        name: 'Login',
        meta: {
            auth: false
        },
    },
    {
        path: '/register',
        components: {
            default: Register,
        },
        name: 'Register',
        meta: {
            auth: false
        },
    },
    {
        path: '/profile',
        components: {
            default: Profile,
            LeftSidebar,
        },
        name: 'Profile',
        meta: {
            auth: true
        },
    },
];
