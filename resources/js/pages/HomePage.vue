<template>
    <div>
        <h2 class="subtitle mt-12 mb-4">Coucou {{ user.name }}</h2>
        <ul class="list clickable">
            <li
                v-for="list in user.todolists"
                :key="list.id"
                @click="goToList(list.id)"
            >
                <p>{{ list.name }} - {{ list.createdAt }}</p>
            </li>
        </ul>
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
    methods: {
        goToList(id) {
            this.$router.push({
                name: "list",
                params: { id: id },
            });
        },
    },
};
</script>
