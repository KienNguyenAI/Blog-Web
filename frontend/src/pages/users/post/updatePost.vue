<template>
    <div>
        <TheHeader :showShadow="false" />

        <PostForm v-if="post" :title="post.title" :content="post.content" :id="post.id" />

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

    data() {
        return {
            post: null,
        };
    },
    mounted() {
        const slug = this.$route.params.slug;
        axios.get(`http://127.0.0.1:8000/api/posts/${slug}`)
            .then(response => {
                this.post = response.data;
            })
            .catch(error => {
                console.error('Có lỗi khi lấy bài viết:', error);
            });
    }

};
</script>