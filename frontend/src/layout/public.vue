<template>
    <TheHeader />
    Day la trang cua user
    <router-view></router-view>
</template>

<script>
import TheHeader from '../components/TheHeader.vue';
export default {
    components: {
        TheHeader
    }
}
</script>