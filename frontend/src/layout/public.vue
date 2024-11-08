<template>
    <TheHeader />

    <div class="container">
        <div class="row">
            <div class="col-8">
                <router-view></router-view>
            </div>
            <div class="col-4">
                <span style="background-color: aqua;"></span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 col-12 mt-3">
                <TheMenu />
            </div>
            <div class="col-sm-4 d-none"></div>
        </div>
    </div>

</template>

<script>
import TheHeader from '../components/TheHeader.vue';
import TheMenu from '../components/TheFeed.vue';
import Card from '../components/Card.vue';

export default {
    components: {
        TheHeader,
        Card,
        TheMenu

    }
}
</script>
