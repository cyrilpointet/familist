<template>
    <div>
        <button icon @click="show = true">
            <span class="material-icons">add</span>
        </button>
        <div v-if="show" class="modal" @click="show = false">
            <form @submit.prevent="handleSubmit" class="modalCard" @click.stop>
                <div class="modalHead">
                    <span class="grow">{{ title }}</span>
                    <span class="material-icons" @click.prevent="show = false">
                        close
                    </span>
                </div>
                <div class="p-4">
                    <label
                        >Nom
                        <input
                            type="text"
                            v-model.trim="$v.value.$model"
                            placeholder="Nom"
                        />
                        <span v-if="$v.value.$error"
                            >Obligatoire (2 lettres min)</span
                        >
                    </label>
                </div>

                <div class="p-2 flex">
                    <button @click.prevent="show = false">Annuler</button>
                    <span class="grow"></span>
                    <button @click.stop type="submit">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { minLength, required } from "vuelidate/lib/validators";

export default {
    name: "input-modal",
    props: ["title"],
    data: () => {
        return {
            show: false,
            value: "",
        };
    },
    validations: {
        value: {
            required,
            minLength: minLength(2),
        },
    },
    methods: {
        handleSubmit() {
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.$emit("done", this.value);
            this.value = "";
            this.show = false;
        },
    },
};
</script>
