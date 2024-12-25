<template>
    <div>
        <div v-if="loading" class="w-100 d-flex justify-content-center">
            <a-spin size="large" />
        </div>

        <div v-else>
            <div class="row ps-3 pe-3">
                <Card v-for="(post, index) in posts" :key="index" :imgSrc="post.image" :category="post.tag.name"
                    :cateSlug="post.tag.slug" :title="post.title" :description="post.description"
                    :avatar="post.user.avatar" :authorName="post.user.name" :createdAt="formatDate(post.created_at)"
                    :slug="post.slug" :name="post.user.username" :isUpvoted="upvotedPosts.includes(post.id)"
                    @toggleUpvote="handleUpvote(post.id)" :voteCount="votes[post.id]"
                    :readTime="calculateReadTime(post.content)" :isSavePost="savedPosts.includes(post.id)"
                    @toggleSave="handelSavePost(post.id)" />
            </div>

        </div>
    </div>
</template>

<script>
import { ref, computed, watchEffect } from "vue";
import { usePosts } from "../../services/post/usePosts";
import Card from '../../components/cards/Card.vue';
import { getUser } from "../../services/auth";
export default {
    components: {
        Card
    },
    setup() {
        const userId = getUser().id;
        const { posts, loading, votes, upvotedPosts, handleUpvote, calculateReadTime, formatDate, handelSavePost, savedPosts } = usePosts(userId);
        watchEffect(() => {
            posts.value.forEach(post => {
                if (!savedPosts.value.includes(post.id)) {
                    savedPosts.value.push(post.id);
                }
            });
        });
        return {
            posts,
            loading,
            votes,
            upvotedPosts,
            handleUpvote,
            calculateReadTime,
            formatDate,
            handelSavePost,
            savedPosts
        };
    }
};
</script>

<style scoped>
.pagination {
    display: flex;
    align-items: center;
}
</style>
