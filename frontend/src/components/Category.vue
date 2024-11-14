<template>
    <a href="" class="text-black topic">{{ topicName }}</a>
</template>

<script>
export default {
    props: {
        topicName: {
            type: String,
            required: true
        }
    }
}
</script>

<style>
.topic {
    border: 1px solid #c4c4c4;
    border-radius: 3rem;
    padding: .5rem 1rem;
    margin-bottom: .5rem;
    margin-right: .375rem;
}
</style>
