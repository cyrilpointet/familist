<template>
    <div>
        <form @submit.prevent="findUser" class="flex items-center gap-4">
            <label class="grow"
                >Email
                <input
                    @keydown="hasSearched = false"
                    type="email"
                    v-model.trim="$v.email.$model"
                    placeholder="email"
                />
                <span v-if="$v.email.$error">Email valide obligatoire</span>
            </label>

            <button icon type="submit" class="mt-4" :disabled="ajaxPending">
                <span class="material-icons">search</span>
            </button>
        </form>

        <div v-if="hasSearched">
            <div v-if="isUserInlist" class="resultCard">
                <p>Une invitation a déjà été envoyée à cette adresse.</p>
            </div>
            <div v-else-if="!userByMail" class="resultCard">
                <p>
                    Aucun utilisateur ne correspond à cet email. Voulez-vous
                    envoyer un email d'invitation à {{ email }} ?
                </p>
                <div class="flex justify-center p-2">
                    <button small @click="inviteUser">envoyer</button>
                </div>
            </div>
            <div v-else>
                <div class="resultCard valid" @click="selectUser">
                    <p class="font-bold">{{ userByMail.name }}</p>
                    <p>{{ userByMail.email }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ApiConsumer } from "../../services/ApiConsumer";
import { EventBus } from "../../services/EventBus";
import { email, required } from "vuelidate/lib/validators";
import { mapState } from "vuex";

export default {
    name: "user-finder",
    data: () => {
        return {
            email: "",
            userByMail: null,
            hasSearched: false,
            ajaxPending: false,
        };
    },
    validations: {
        email: {
            required,
            email,
        },
    },
    computed: {
        ...mapState({
            list: (state) => state.todolist.todolist,
        }),
        isUserInlist() {
            const invitations = this.list.invitations.filter((elem) => {
                return elem.email === this.email;
            });
            return invitations.length > 0;
        },
    },
    methods: {
        async findUser() {
            this.userByMail = null;
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.ajaxPending = true;
            try {
                const userByMail = await ApiConsumer.post("user/find", {
                    email: this.email,
                });
                this.userByMail = userByMail;
            } catch (error) {
                if (error.response.status !== 404) {
                    EventBus.$emit(
                        "alert",
                        "Une erreur est survenue. Réessayez plus tard."
                    );
                }
            }
            this.ajaxPending = false;
            this.hasSearched = true;
        },
        selectUser() {
            this.$emit("userSelected", this.userByMail.id);
        },
        inviteUser() {
            this.$emit("inviteUser", this.email);
        },
    },
};
</script>

<style lang="scss" scoped>
.resultCard {
    @apply border border-gray p-2 rounded my-2 shadow;
    transition: background-color 0.2s linear;
    &.valid {
        @apply bg-primary text-white;
        cursor: pointer;
        &:hover {
            @apply bg-primarylight;
        }
    }
}
</style>
