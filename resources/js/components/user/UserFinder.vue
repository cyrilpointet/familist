<template>
    <div>
        <div class="flex items-center gap-4">
            <label class="grow"
                >Email
                <input
                    @keydown="hasSearched = false"
                    type="email"
                    v-model="email"
                    placeholder="email"
                />
            </label>

            <button icon @click="findUser" class="mt-4" :disabled="ajaxPending">
                <span class="material-icons">search</span>
            </button>
        </div>

        <div v-if="hasSearched">
            <div v-if="!userByMail" class="resultCard">
                <p>Aucun utilisateur ne correspond à cet email</p>
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
    methods: {
        async findUser() {
            this.userByMail = null;
            this.ajaxPending = true;
            try {
                const userByMail = await ApiConsumer.post("user/find", {
                    email: this.email,
                });
                this.userByMail = userByMail;
            } catch (error) {
                EventBus.$emit(
                    "alert",
                    "Une erreur est survenue. Réessayez plus tard."
                );
            }
            this.ajaxPending = false;
            this.hasSearched = true;
        },
        selectUser() {
            this.$emit("userSelected", this.userByMail.id);
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
