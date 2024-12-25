<template>
    <div :class="['header', { 'no-shadow': !showShadow }]">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-6 d-flex align-items-center justify-content-start">
                    <a href="/"> <img src="../assets/foxtalesLogo.webp" alt="" style="width: 7rem;"></a>
                </div>
                <div class="col-sm-6 col-6 d-sm-flex align-items-center justify-content-sm-end">
                    <HeaderRight />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import HeaderRight from './HeaderRight.vue';
export default {
    components: {
        HeaderRight
    },
    props: {
        showShadow: {
            type: Boolean,
            default: true
        }
    },

}
</script>

<style scoped>
.header {
    padding: 1rem;
    box-shadow: 0 0.25rem 0.375rem rgba(0, 0, 0, 0.1);
}

.no-shadow {
    box-shadow: none;
}

.login {
    padding: 0.75rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    background-color: #00aaff;
    color: white;
    font-size: 1.1rem;
    border-radius: 1.45rem;
}

.login:hover {
    background-color: #0087ca;
}

.signin {
    color: black;
    font-size: 1.1rem;
}
</style>
