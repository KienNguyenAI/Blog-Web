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
            <div class="col-sm-8 col-12 d-sm-flex mt-3">

                <Card />
            </div>
            <div class="col-sm-4 d-none"></div>
        </div>
    </div>

</template>

<script>
import TheHeader from '../components/TheHeader.vue';
import Card from '../components/Card.vue';
export default {
    components: {
        TheHeader,
        Card
    }
}
</script>