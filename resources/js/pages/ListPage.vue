<template>
    <div>
        <div v-if="!list">Loading</div>
        <div v-else class="mt-4">
            <h1 class="title text-center">{{ list.name }}</h1>
            <TodolistMembers />
            <ProductList />
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import TodolistMembers from "../components/todolist/TodolistMembers";
import ProductList from "../components/product/ProductList";

export default {
    name: "home-page",
    components: { TodolistMembers, ProductList },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
            list: (state) => state.todolist.todolist,
        }),
    },
    async created() {
        if (!this.list || this.$route.params.id !== this.list.id) {
            await this.refreshList(this.$route.params.id);
        }
    },
    async beforeRouteUpdate(to, from, next) {
        if (parseInt(from.params.id) !== to.params.id) {
            await this.refreshList(to.params.id);
            next();
        }
    },
    methods: {
        async refreshList(id) {
            try {
                await this.$store.dispatch("todolist/getList", id);
            } catch {
                this.$router.push({ name: "home" });
            }
        },
    },
};
</script>
