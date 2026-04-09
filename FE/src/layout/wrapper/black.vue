<template>
    <router-view v-slot="{ Component }">
        <transition name="fade-page" mode="out-in">
            <component :is="Component" />
        </transition>
    </router-view>
</template>
<script>
export default {
    name: 'LayoutBlack',
    mounted() {
        // Essential scripts only if not already loaded
        if (!window.bootstrap) {
            import("../../assets/js/bootstrap.bundle.min.js");
        }
    }
}
</script>
<style>
@import "../../assets/css/bootstrap.min.css";
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");
@import "../../assets/css/app.css";
@import "../../assets/css/icons.css";

/* Smooth Page Transitions */
.fade-page-enter-active,
.fade-page-leave-active {
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.fade-page-enter-from {
    opacity: 0;
    transform: translateY(10px);
}

.fade-page-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
