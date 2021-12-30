<template>
    <div>
        <button icon @click="show = true">
            <span class="material-icons">add</span>
        </button>
        <div v-if="show" class="modal" @click="show = false">
            <div class="modalCard" @click.stop>
                <div class="modalHead">
                    <span class="grow">{{ title }}</span>
                    <span class="material-icons" @click="show = false">
                        close
                    </span>
                </div>
                <div class="p-4">
                    <label
                        >Nom
                        <input type="text" v-model="value" placeholder="Nom" />
                    </label>
                </div>

                <div class="p-2 flex">
                    <button @click="show = false">Annuler</button>
                    <span class="grow"></span>
                    <button @click="handleSubmit">Confirmer</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "input-modal",
    props: ["title"],
    data: () => {
        return {
            show: false,
            value: "",
        };
    },
    methods: {
        handleSubmit() {
            this.$emit("done", this.value);
            this.value = "";
            this.show = false;
        },
    },
};
</script>
