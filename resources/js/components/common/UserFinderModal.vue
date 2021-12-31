<template>
    <div>
        <button icon @click="show = true">
            <span class="material-icons">add</span>
        </button>
        <div v-if="show" class="modal" @click="show = false">
            <div class="modalCard" @click.stop>
                <div class="modalHead">
                    <span class="grow">Ajouter un membre</span>
                    <span class="material-icons" @click="show = false">
                        close
                    </span>
                </div>
                <div class="p-4">
                    <UserFinder @userSelected="addMember($event)" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserFinder from "../user/UserFinder";
import { mapState } from "vuex";
import { EventBus } from "../../services/EventBus";

export default {
    name: "input-modal",
    props: ["title"],
    components: { UserFinder },
    data: () => {
        return {
            show: false,
            value: "",
        };
    },
    computed: {
        ...mapState({
            list: (state) => state.todolist.todolist,
        }),
    },
    methods: {
        async addMember(id) {
            const members = this.list.users.filter((elem) => {
                return elem.id === id;
            });
            if (members.length > 0) {
                EventBus.$emit(
                    "alert",
                    "Cet utilisateur partage déjà cette liste"
                );
                return;
            }
            try {
                await this.$store.dispatch("todolist/addMember", {
                    listId: this.list.id,
                    userId: id,
                });
                EventBus.$emit("alert", "Nouvel utilisateur ajouté");
                this.show = false;
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
