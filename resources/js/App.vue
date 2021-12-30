<template>
    <div class="bg-lightgray min-h-screen">
        <HeaderBar />
        <div class="container mx-auto px-2 md:px-0">
            <router-view />
        </div>
        <Confirm />
        <AlertBar />
    </div>
</template>

<script>
import HeaderBar from "./components/common/HeaderBar";
import Confirm from "./components/common/Confirm";
import AlertBar from "./components/common/AlertBar";

export default {
    name: "App",
    components: { HeaderBar, Confirm, AlertBar },
};
</script>
