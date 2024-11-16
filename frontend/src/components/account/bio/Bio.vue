<template>
    <div>
        <div class="container">
            <div class="form-bio">
                <JobInfo />
                <EduInfo />
                <AddressInfo />
                <HomeTownInfo />
                <div class=" mt-5 d-flex justify-content-end">
                    <button class="save">Lưu</button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import JobInfo from './JobInfo.vue';
import EduInfo from './EduInfo.vue';
import AddressInfo from './AddressInfo.vue';
import HomeTownInfo from './HomeTownInfo.vue';
export default {
    components: {
        JobInfo,
        EduInfo,
        AddressInfo,
        HomeTownInfo
    },
};
</script>


<style>
.save {
    background-color: #4096ff;
    color: white;
    padding: 1rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;

    border: 0;
    border-radius: 1.5rem;
    cursor: pointer;
}

.save:hover {
    background-color: #3182ce;
}
</style>
