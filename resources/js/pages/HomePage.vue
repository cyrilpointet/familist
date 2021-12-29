<template>
    <div>
        <h2 class="subtitle mt-12 mb-4">Coucou {{ user.name }}</h2>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    name: "home-page",
    components: {},
    computed: {
        ...mapState({
            user: (state) => state.user.user,
        }),
    },
};
</script>
