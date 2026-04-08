<template>
    <div>
        <div class="client-wrapper" style="min-height: 100vh;">
            <TopClient></TopClient>
            <router-view></router-view>

        </div>
        <BotClient></BotClient>
    </div>
</template>
<script>
import "../../assets/js/bootstrap.bundle.min.js";
import "../../assets/js/jquery.min.js";
import "../../assets/js/app.js";
import TopClient from "../components/Client/TopClient.vue";
import BotClient from "../components/Client/BotClient.vue";
export default {
    components: {
        TopClient,
        BotClient
    }
}
</script>
<style>
@import "../../assets/css/bootstrap.min.css";
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");
@import "../../assets/css/app.css";
@import "../../assets/css/icons.css";
</style>
