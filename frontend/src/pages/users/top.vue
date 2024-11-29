<template>
    <div>
        <div v-if="loading" class="w-100 d-flex justify-content-center">
            <a-spin size="large" />
        </div>

        <div v-else>
            <div class="row">
                <Card v-for="(post, index) in paginatedPosts" :key="index" :imgSrc="post.image"
                    :category="post.tag.name" :cateSlug="post.tag.slug" :title="post.title"
                    :description="post.description" :avatar="post.user.avatar" :authorName="post.user.name"
                    :createdAt="formatDate(post.created_at)" :slug="post.slug" :name="post.user.username"
                    :isUpvoted="upvotedPosts.includes(post.id)" @toggleUpvote="handleUpvote(post.id)"
                    :voteCount="votes[post.id]" :readTime="calculateReadTime(post.content)"
                    :isSavePost="savedPosts.includes(post.id)" @toggleSave="handelSavePost(post.id)" />
            </div>

            <a-pagination v-model:current="currentPage" :total="totalPosts" :page-size="itemsPerPage" show-less-items
                @change="handlePageChange" class="d-flex justify-content-center mt-4" />
        </div>
    </div>
</template>

<script>
import { ref, computed } from "vue";
import { usePosts } from "../../services/post/usePosts";
import Card from '../../components/cards/Card.vue';

export default {
    components: {
        Card
    },
    setup() {
        const { posts, loading, votes, upvotedPosts, handleUpvote, calculateReadTime, formatDate, handelSavePost, savedPosts } = usePosts('top');

        const itemsPerPage = 20;
        const currentPage = ref(1);
        const totalPosts = computed(() => posts.value.length);
        const paginatedPosts = computed(() => {
            const start = (currentPage.value - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            return posts.value.slice(start, end);
        });

        const handlePageChange = (page) => {
            currentPage.value = page;
        };

        return {
            posts,
            loading,
            votes,
            upvotedPosts,
            handleUpvote,
            calculateReadTime,
            formatDate,
            paginatedPosts,
            currentPage,
            totalPosts,
            itemsPerPage,
            handlePageChange,
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
