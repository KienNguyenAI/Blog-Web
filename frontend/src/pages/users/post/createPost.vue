<template>
    <div>
        <TheHeader :showShadow="false" />
        <PostForm />
    </div>
</template>

<script>
import PostForm from "@/components/posts/PostForm.vue";
import TheHeader from "../../../components/TheHeader.vue";
export default {
    components: {
        PostForm,
        TheHeader
    },
};
</script>