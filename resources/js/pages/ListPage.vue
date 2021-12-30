<template>
    <div>
        <div v-if="!list">Loading</div>
        <div v-else class="mt-4">
            <h1 class="title text-center">{{ list.name }}</h1>
            <Accordion class="mt-4 bg-white p-2 shadow">
                <template v-slot:title>
                    <p class="subtitle grow">Membres</p>
                </template>
                <template v-slot:body>
                    <ul class="list">
                        <li
                            v-for="member in list.users"
                            :key="member.id"
                            class="flex items-center"
                        >
                            <p class="grow">{{ member.name }}</p>
                            <button icon>
                                <span class="material-icons">delete</span>
                            </button>
                        </li>
                    </ul>
                </template>
            </Accordion>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import Accordion from "../components/common/Accordion";

export default {
    name: "home-page",
    components: { Accordion },
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
                this.$store.dispatch("todolist/getList", id);
            } catch {
                this.$router.push({ name: "home" });
            }
        },
    },
};
</script>
