<template>
    <header class="header">
        <div class="main px-2 md:px-0">
            <h4 class="grow title">Team list</h4>
            <router-link v-if="isLogged" to="/">
                <button icon>
                    <span class="material-icons">home</span>
                </button>
            </router-link>

            <button icon v-if="isLogged" @click="logout">
                <span class="material-icons">logout</span>
            </button>
        </div>
    </header>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "header-bar",
    computed: {
        ...mapGetters({
            isLogged: "user/isLogged",
        }),
    },
    methods: {
        async logout() {
            await this.$store.dispatch("user/logout");
            this.$router.push({ name: "login" });
        },
    },
};
</script>

<style lang="scss" scoped>
.header {
    @apply bg-primary text-white shadow-xl;
}
.main {
    @apply container mx-auto bg-primary text-white flex items-center py-2 gap-4;
}
</style>
