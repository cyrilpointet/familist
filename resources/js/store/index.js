import Vue from "vue";
import Vuex from "vuex";
import { userStore } from "./userStore";
import { todolistStore } from "./todolistStore";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user: userStore,
        todolist: todolistStore,
    },
});
