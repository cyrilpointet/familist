import HomePage from "../pages/HomePage.vue";
import LoginPage from "../pages/LoginPage.vue";
import ListPage from "../pages/ListPage";

export const Routes = [
    {
        path: "/",
        name: "home",
        component: HomePage,
        meta: { requiresAuth: true },
    },
    {
        path: "/login",
        name: "login",
        component: LoginPage,
        meta: { preloadUser: true },
    },
    {
        path: "/list/:id",
        name: "list",
        component: ListPage,
        meta: { requiresAuth: true },
    },
];
