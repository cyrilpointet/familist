<template>
    <transition name="slide">
        <div v-if="show" class="positionner">
            <div class="main">
                <p>{{ text }}</p>
            </div>
        </div>
    </transition>
</template>

<script>
import { EventBus } from "../../services/EventBus";

export default {
    name: "alert-bar",
    data: () => {
        return {
            show: false,
            text: "",
        };
    },
    created() {
        EventBus.$on("alert", (text) => {
            this.text = text;
            this.show = true;
            setTimeout(() => {
                this.show = false;
            }, 2000);
        });
    },
};
</script>

<style lang="scss" scoped>
.positionner {
    @apply flex justify-center fixed top-4 left-0 right-0;
    z-index: 20;
}
.main {
    @apply bg-white shadow-xl border-2 border-gray rounded-xl p-4;
}
</style>
