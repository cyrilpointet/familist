<template>
    <div>
        <h1 class="title text-center mb-4">Créer un compte</h1>
        <form @submit.prevent="register" class="flex flex-col gap-4">
            <label
                >Nom
                <input
                    type="text"
                    v-model.trim="$v.name.$model"
                    placeholder="name"
                />
                <span v-if="$v.name.$error">Obligatoire (2 lettres min)</span>
            </label>
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
            <button type="submit">Valider</button>
        </form>
    </div>
</template>

<script>
import { required, minLength, email } from "vuelidate/lib/validators";
import { mapGetters, mapState } from "vuex";
import { EventBus } from "../../services/EventBus";

export default {
    name: "user-register",
    data: () => {
        return {
            name: "",
            email: "",
            password: "",
        };
    },
    validations: {
        name: {
            required,
            minLength: minLength(2),
        },
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
        async register() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            try {
                await this.$store.dispatch("user/createUser", {
                    name: this.name,
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
