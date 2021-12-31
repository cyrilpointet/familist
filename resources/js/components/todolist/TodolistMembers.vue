<template>
    <div>
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
                        <button icon @click="confirmDelete(member.id)">
                            <span class="material-icons">delete</span>
                        </button>
                    </li>
                    <li class="flex justify-end">
                        <UserFinderModal />
                    </li>
                </ul>
            </template>
        </Accordion>
    </div>
</template>

<script>
import Accordion from "../common/Accordion";
import { mapState } from "vuex";
import { EventBus } from "../../services/EventBus";
import UserFinderModal from "../common/UserFinderModal";

export default {
    name: "todolist-members",
    components: { Accordion, UserFinderModal },
    computed: {
        ...mapState({
            list: (state) => state.todolist.todolist,
            user: (state) => state.user.user,
        }),
    },
    methods: {
        confirmDelete(id) {
            EventBus.$emit("openConfirmModal", {
                title: "Arrêter le partage",
                content:
                    id !== this.user.id
                        ? "Voulez-vous supprimer ce membre de la liste ?"
                        : "Voulez-vous quitter la liste ?",
                action: () => {
                    this.removeMember(id);
                },
            });
        },
        async removeMember(id) {
            try {
                await this.$store.dispatch("todolist/removeMember", {
                    listId: this.list.id,
                    userId: id,
                });
            } catch {
                EventBus.$emit(
                    "alert",
                    "Une erreur est survenue. Réessayez plus tard."
                );
            }

            if (!this.list) {
                this.$router.push({ name: "home" });
                EventBus.$emit("alert", "Vous avez quitté la liste");
            } else {
                EventBus.$emit("alert", "Membre supprimé");
            }
        },
    },
};
</script>
