<template>
    <div>
        <h1 class="title text-center">Me connecter</h1>
        <form @submit.prevent="login" class="flex flex-col gap-4">
            <label
                >Email
                <input
                    type="text"
                    v-model.trim="$v.email.$model"
                    placeholder="email"
                />
                <span v-if="$v.email.$error">Email valide obligatoire</span>
            </label>
            <label
                >Mot de passe
                <input
                    type="password"
                    v-model.trim="$v.password.$model"
                    placeholder="password"
                />
                <span v-if="$v.password.$error"
                    >Obligatoire (8 lettres min)</span
                >
            </label>
            <button type="submit">valider</button>
        </form>
    </div>
</template>

<script>
import { mapGetters, mapState } from "vuex";
import { EventBus } from "../../services/EventBus";
import { email, minLength, required } from "vuelidate/lib/validators";

export default {
    name: "user-login",
    data: () => {
        return {
            email: "",
            password: "",
        };
    },
    validations: {
        email: {
            required,
            email,
        },
        password: {
            required,
            minLength: minLength(8),
        },
    },
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
        ...mapGetters({
            isLogged: "user/isLogged",
        }),
    },
    methods: {
        async login() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            try {
                await this.$store.dispatch("user/logUser", {
                    email: this.email,
                    password: this.password,
                });
                this.$router.push({ name: "home" });
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
