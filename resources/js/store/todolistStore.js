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
        addProduct(state, product) {
            state.todolist.products.push({
                id: product.id,
                name: product.name,
            });
        },
        removeProduct(state, id) {
            state.todolist.products = state.todolist.products.filter((elem) => {
                return elem.id !== id;
            });
        },
        addInvitation(state, invitation) {
            state.todolist.invitations.push({
                id: invitation.id,
                email: invitation.email,
            });
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
                context.commit("user/removeList", values.listId, {
                    root: true,
                });
            } else {
                const newList = new Todolist(data);
                context.commit("setList", newList);
                context.commit("user/updateList", data, { root: true });
            }
            return;
        },
        async addProduct(context, values) {
            const product = await ApiConsumer.post(
                `todolist/${values.listId}/product`,
                {
                    name: values.name,
                }
            );
            context.commit("addProduct", product);
            return;
        },
        async removeProduct(context, values) {
            await ApiConsumer.delete(`todolist/${values.listId}/product`, {
                id: values.productId,
            });
            context.commit("removeProduct", values.productId);
            return;
        },
        async addInvitation(context, values) {
            const invitation = await ApiConsumer.post(
                `todolist/${values.listId}/invitation`,
                {
                    email: values.email,
                }
            );
            context.commit("addInvitation", invitation);
            return;
        },
    },
};
