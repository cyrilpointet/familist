<template>
    <div v-if="show" class="modal" @click="show = false">
        <div class="modalCard">
            <div class="modalHead">
                <span class="grow">{{ title }}</span>
                <span class="material-icons" @click="show = false">close</span>
            </div>
            <div class="p-4">{{ content }}</div>
            <div class="p-2 flex">
                <button @click="show = false">Annuler</button>
                <span class="grow"></span>
                <button @click="action">Confirmer</button>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../services/EventBus";

export default {
    name: "confirm-modal",
    data: () => {
        return {
            show: false,
            title: "title",
            content: "Lorem ipsum dolor sit amet, consectetur",
            action: () => {
                console.log("coucou");
            },
        };
    },
    created() {
        EventBus.$on("openConfirmModal", (event) => {
            this.title = event.title;
            this.content = event.content;
            this.action = event.action;
            this.show = true;
        });
    },
};
</script>
