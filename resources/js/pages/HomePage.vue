<template>
    <div>
        <h2 class="subtitle mt-12 mb-4">Coucou {{ user.name }}</h2>
        <ul class="list clickable bg-white">
            <li
                v-for="list in user.todolists"
                :key="list.id"
                @click="goToList(list.id)"
                class="flex items-center"
            >
                <p class="grow">{{ list.name }} - {{ list.createdAt }}</p>
                <button icon @click.stop="confirmDelete(list.id)">
                    <span class="material-icons">delete</span>
                </button>
            </li>
        </ul>
        <div class="flex py-2 justify-end">
            <InputModal title="Créer une liste" @done="addList" class="mr-2" />
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import InputModal from "../components/common/InputModal";
import { EventBus } from "../services/EventBus";

export default {
    name: "home-page",
    components: { InputModal },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
    },
    methods: {
        goToList(id) {
            this.$router.push({
                name: "list",
                params: { id: id },
            });
        },
        async addList(name) {
            try {
                const newList = await this.$store.dispatch(
                    "todolist/createList",
                    name
                );
                EventBus.$emit("alert", "Nouvelle liste crée");
                this.goToList(newList.id);
            } catch {
                EventBus.$emit(
                    "alert",
                    "Une erreur est survenue. Réessayez plus tard."
                );
            }
        },
        confirmDelete(id) {
            EventBus.$emit("openConfirmModal", {
                title: "Supprimer",
                content: "Voulez-vous supprimer cette liste ?",
                action: () => {
                    this.deleteList(id);
                },
            });
        },
        async deleteList(id) {
            try {
                await this.$store.dispatch("todolist/deleteList", id);
                EventBus.$emit("alert", "Liste supprimée");
            } catch {
                EventBus.$emit(
                    "alert",
                    "Une erreur est survenue. Réessayez plus tard."
                );
            }
        },
    },
};
</script>
