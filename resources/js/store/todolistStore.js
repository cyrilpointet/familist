import { ApiConsumer } from "../services/ApiConsumer";
import { Todolist } from "../models/Todolist";

export const todolistStore = {
    namespaced: true,

    state: () => ({
        todolist: null,
    }),
    mutations: {
        setList(state, value) {
            state.todolist = value;
        },
    },
    actions: {
        createList(context, values) {
            ApiConsumer.post("todolist", values).then((data) => {
                context.commit("setList", new Todolist(data));
                return;
            });
        },
        getList(context, id) {
            ApiConsumer.get(`todolist/${id}`).then((data) => {
                console.log(data);
                context.commit("setList", new Todolist(data));
                return;
            });
        },
    },
};
