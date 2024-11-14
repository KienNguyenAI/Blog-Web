<template>
    <TheHeader />
    <div class="pages">
        <Main />
        <div class="row">
            <div class="col-8">
                <router-view></router-view>
            </div>
            <div class="col-4">
                <span style="background-color: aqua;"></span>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-12 mt-3 ps:pe-3 order-sm-1 order-2">
                    <TheMenu />
                </div>
                <div class="col-sm-4 col-12 order-sm-2 order-1">
                    <Topic />
                </div>
            </div>
        </div>
    </div>
    <router-view></router-view>
</template>

<script>
import TheHeader from '../components/TheHeader.vue';
import TheMenu from '../components/TheFeed.vue';
import Card from '../components/Card.vue';
import Main from '../pages/users/index.vue';
import Topic from '../pages/users/topic.vue';
export default {
    components: {
        TheHeader,
        Card,
        TheMenu,
        Main,
        Topic
    },
}
</script>
