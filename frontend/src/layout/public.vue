<template>
    <TheHeader />
    <div class="pages">
        <router-view></router-view>

        <div class="container" v-if="!isExcludedPath">
            <div class="row">
                <div class="col-sm-8 col-12 mt-3 ps:pe-3 order-sm-1 order-2">
                    <router-link to="/categories">a</router-link>
                    <TheFeed />
                </div>
                <div class="col-sm-4 col-12 order-sm-2 order-1">
                    <Topic />
                </div>
            </div>
        </div>
    </div>
    <TheFooter />
</template>

<script>
import TheHeader from '../components/TheHeader.vue';
import TheFooter from '../components/TheFooter.vue';
import TheFeed from '../pages/users/feed.vue';
import Topic from '../pages/users/topic.vue';

export default {
    components: {
        TheHeader,
        TheFooter,
        TheFeed,
        Topic
    },
    data() {
        return {
            excludedPaths: [
                '/account',
                '/top-blogs',
            ]
        };
    },
    computed: {

        isExcludedPath() {
            return this.excludedPaths.some(path => this.$route.path.includes(path));
        }
    }
}
</script>
