import { ApiConsumer } from "../services/ApiConsumer";
import { User } from "../models/User";

export const userStore = {
    namespaced: true,

    state: () => ({
        user: null,
        token: null,
    }),
    getters: {
        isLogged: (state) => {
            return state.user !== null && state.token !== null;
        },
    },
    mutations: {
        setUser(state, value) {
            state.user = value;
        },
        setToken(state, value) {
            state.token = value;
        },
        addList(state, list) {
            state.user.todolists.push({
                id: list.id,
                name: list.name,
                createdAt: new Date(list.created_at).toLocaleDateString(
                    "fr-FR"
                ),
            });
        },
        updateList(state, list) {
            state.user.todolists = state.user.todolists.filter((elem) => {
                return elem.id !== list.id;
            });
            state.user.todolists.push({
                id: list.id,
                name: list.name,
                createdAt: new Date(list.created_at).toLocaleDateString(
                    "fr-FR"
                ),
            });
        },
        removeList(state, id) {
            console.log(id);
            state.user.todolists = state.user.todolists.filter((list) => {
                return list.id !== id;
            });
        },
    },
    actions: {
        storeUserAndToken(context, value) {
            const user = new User(value.user);
            context.commit("setUser", user);
            context.commit("setToken", value.token);
            ApiConsumer.setToken(value.token);
            localStorage.setItem("token", value.token);
        },

        async createUser(context, values) {
            const data = await ApiConsumer.post("user/register", values);
            context.dispatch("storeUserAndToken", data);
            return;
        },

        logUser(context, values) {
            return ApiConsumer.post("user/login", values).then((data) => {
                context.dispatch("storeUserAndToken", data);
            });
        },

        getUserWithToken(context) {
            return new Promise((resolve, reject) => {
                ApiConsumer.get("user/profile")
                    .then((data) => {
                        const user = new User(data);
                        context.commit("setUser", user);
                        resolve();
                    })
                    .catch((e) => {
                        reject(e);
                    });
            });
        },

        async logout(context) {
            context.commit("setUser", null);
            context.commit("setToken", null);
            await ApiConsumer.post("user/logout");
            ApiConsumer.removeToken();
            localStorage.removeItem("token");
            return;
        },
    },
};
