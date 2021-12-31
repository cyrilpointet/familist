<template>
    <div class="bg-white p-2 mt-4 shadow">
        <p class="subtitle grow mb-2">Items</p>
        <ul class="list">
            <li
                v-for="product in list.products"
                :key="product.id"
                class="flex items-center"
            >
                <p class="grow">{{ product.name }}</p>
                <button
                    icon
                    @click="deleteProduct(product.id)"
                    :disabled="ajaxPending"
                >
                    <span class="material-icons">delete</span>
                </button>
            </li>
            <li v-if="list.products.length < 1">
                <p>Pas encore d'item dans la liste</p>
            </li>
            <li class="flex py-2 justify-end">
                <InputModal title="Créer une liste" @done="addProduct" />
            </li>
        </ul>
    </div>
</template>

<script>
import { mapState } from "vuex";
import { EventBus } from "../../services/EventBus";
import InputModal from "../common/InputModal";

export default {
    name: "product-list",
    components: { InputModal },
    data: () => {
        return {
            ajaxPending: false,
        };
    },
    computed: {
        ...mapState({
            list: (state) => state.todolist.todolist,
        }),
    },
    methods: {
        async addProduct(name) {
            try {
                await this.$store.dispatch("todolist/addProduct", {
                    listId: this.list.id,
                    name: name,
                });
                EventBus.$emit("alert", "Produit ajouté");
            } catch {
                EventBus.$emit(
                    "alert",
                    "Une erreur est survenue. Réessayez plus tard."
                );
            }
        },
        async deleteProduct(id) {
            this.ajaxPending = true;
            try {
                await this.$store.dispatch("todolist/removeProduct", {
                    listId: this.list.id,
                    productId: id,
                });
            } catch {
                EventBus.$emit(
                    "alert",
                    "Une erreur est survenue. Réessayez plus tard."
                );
            }
            this.ajaxPending = false;
            EventBus.$emit("alert", "Produit supprimé");
        },
    },
};
</script>
