<template>
    <div class="popular mt-3">
        <div class="container">
            <div class="trending-carousel">
                <div class="align-items-center d-flex pt-3">
                    <div class="trending-title fw-bold">
                        NHỮNG BÀI VIẾT PHỔ BIẾN
                    </div>
                </div>

                <div class="d-sm-flex  flex-wrap">
                    <div class="row">
                        <div class="col-sm-6 trending-card">
                            <Card />
                        </div>
                        <div class="col-sm-6 trending-card">
                            <Card />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 trending-card">
                            <Card />
                        </div>
                        <div class="col-sm-6 trending-card">
                            <Card />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="homepage_trending mt-3">
        <div class="container">
            <div class="trending-carousel">
                <div class="align-items-center d-flex pt-3">
                    <div class="trending-title fw-bold">
                        NỔI BẬT TRONG THÁNG
                    </div>
                    <span class="text-muted d-none d-sm-flex">&emsp;|&emsp;</span>
                    <router-link :to="{ path: '/top-blogs', query: $route.query }">
                        <a href="#" class="text-decoration-none text-dark d-none d-sm-flex">Xem TOP 10 bài viết</a>
                    </router-link>

                </div>

                <div class="d-sm-flex flex-wrap">
                    <div class="col-md-3 col-12 trending-card">
                        <CardVertical />
                    </div>
                    <div class="col-md-3 col-12 trending-card">
                        <CardVertical />
                    </div>
                    <div class="col-md-3 col-12 trending-card">
                        <CardVertical />
                    </div>
                    <div class="col-md-3 col-12 trending-card">
                        <CardVertical />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CardVertical from '../../components/CardVertical.vue';
import Card from '../../components/Card.vue';
export default {
    components: {
        CardVertical,
        Card
    }
}
</script>

<style>
.homepage_trending {
    width: 100%;
    background-color: #fafafa;
}

.trending-card {
    padding-right: .5rem;
    padding-left: .5rem;
}
</style>
