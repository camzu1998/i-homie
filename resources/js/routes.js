import Home from "./Components/Home.vue";
import Register from "./Components/Auth/Register.vue";
import Profile from "./Components/User/Profile.vue";
import LeftSidebar from "./Components/Partials/Menu/LeftSidebar.vue";
import LoginForm from "./Components/Auth/LoginForm.vue";
import Houses from "./Components/House/Houses.vue";
import Rooms from "./Components/Room/Rooms.vue";
import Duties from "./Components/Duty/Duties.vue";

export default [
    {
        path: '/',
        components: {
            default: Home,
            LeftSidebar,
        },
        name: 'Home',
        meta: {
            auth: true,
            sidebar: false,
            icon: 'fa-solid fa-home'
        },
    },
    {
        path: '/login',
        components: {
            default: LoginForm,
        },
        name: 'Login',
        meta: {
            auth: false,
            sidebar: false,
            icon: 'fa-solid fa-right-to-bracket'
        },
    },
    {
        path: '/register',
        components: {
            default: Register,
        },
        name: 'Register',
        meta: {
            auth: false,
            sidebar: false,
            icon: 'fa-solid fa-user-plus'
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
            auth: true,
            sidebar: false
        },
    },
    {
        path: '/duties',
        components: {
            default: Duties,
            LeftSidebar,
        },
        name: 'Duties',
        meta: {
            auth: true,
            sidebar: true,
            icon: 'fa-regular fa-clipboard'
        },
    },
    {
        path: '/rooms',
        components: {
            default: Rooms,
            LeftSidebar,
        },
        name: 'Rooms',
        meta: {
            auth: true,
            sidebar: true,
            icon: 'fa-solid fa-kaaba'
        },
    },
    {
        path: '/fridge',
        components: {
            default: Profile,
            LeftSidebar,
        },
        name: 'Fridge',
        meta: {
            auth: true,
            sidebar: true,
            icon: 'fa-solid fa-carrot'
        },
    },
    {
        path: '/entries',
        components: {
            default: Profile,
            LeftSidebar,
        },
        name: 'Entries',
        meta: {
            auth: true,
            sidebar: true,
            icon: 'fa-regular fa-calendar-days'
        },
    },
    {
        path: '/houses',
        components: {
            default: Houses,
            LeftSidebar,
        },
        name: 'House',
        meta: {
            auth: true,
            sidebar: true,
            icon: 'fa-solid fa-house'
        },
    },
];
