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
        async createList(context, name) {
            const data = await ApiConsumer.post("todolist", {
                name: name,
            });
            const newList = new Todolist(data);
            context.commit("setList", newList);
            context.commit("user/addList", data, { root: true });
            return newList;
        },
        async getList(context, id) {
            const data = await ApiConsumer.get(`todolist/${id}`);
            const newList = new Todolist(data);
            context.commit("setList", newList);
            return newList;
        },
        async deleteList(context, id) {
            await ApiConsumer.delete(`todolist/${id}`);
            context.commit("setList", null);
            context.commit("user/removeList", id, { root: true });
            return;
        },
        async addMember(context, values) {
            const data = await ApiConsumer.post(
                `todolist/${values.listId}/user`,
                {
                    id: values.userId,
                }
            );
            const newList = new Todolist(data);
            context.commit("setList", newList);
            context.commit("user/updateList", data, { root: true });
            return;
        },
        async removeMember(context, values) {
            const data = await ApiConsumer.delete(
                `todolist/${values.listId}/user`,
                {
                    id: values.userId,
                }
            );
            if (values.userId === context.rootState.user.user.id) {
                context.commit("setList", null);
                context.commit("user/removeList", data.id, { root: true });
            } else {
                const newList = new Todolist(data);
                context.commit("setList", newList);
                context.commit("user/updateList", data, { root: true });
            }
            return;
        },
    },
};
