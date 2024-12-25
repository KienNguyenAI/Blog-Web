<template>
    <TheHeader />
    <div class="pages mt-3">
        <div class="row">
            <div class="col-2 ">
                <TheMenu />
            </div>
            <div class="col-10">
                <router-view></router-view>
            </div>
        </div>


    </div>
    <TheFooter />
</template>

<script>
import TheHeader from '../admin/component/TheHeader.vue';
import TheMenu from '../admin/component/TheMenu.vue';

export default {
    components: {
        TheHeader,
        TheMenu
    },
}
</script>
