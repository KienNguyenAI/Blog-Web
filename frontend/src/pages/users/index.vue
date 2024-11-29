<template>
    <div class="popular mt-3">
        <div class="container">
            <div class="trending-carousel">
                <div class="align-items-center d-flex pt-3">
                    <div class="trending-title fw-bold">
                        NHỮNG BÀI VIẾT PHỔ BIẾN
                    </div>
                </div>
                <div class="d-sm-flex flex-wrap row">
                    <div v-for="(post, index) in posts.slice(0, 4)" :key="index" class="col-sm-6 col-12">
                        <Card :imgSrc="post.image" :category="post.tag.name" :cateSlug="post.tag.slug"
                            :title="post.title" :description="post.description" :avatar="post.user.avatar"
                            :authorName="post.user.name" :createdAt="formatDate(post.created_at)" :slug="post.slug"
                            :name="post.user.username" :isUpvoted="upvotedPosts.includes(post.id)"
                            @toggleUpvote="handleUpvote(post.id)" :voteCount="votes[post.id]"
                            :readTime="calculateReadTime(post.content)" :isSavePost="savedPosts.includes(post.id)"
                            @toggleSave="handelSavePost(post.id)" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="homepage_trending mt-3">
        <div class="container">
            <div class="trending-carousel">
                <div class="align-items-center d-flex pt-3">
                    <div class="trending-title fw-bold">
                        NỔI BẬT TRONG THÁNG
                    </div>
                    <span class="text-muted d-none d-sm-flex">&emsp;|&emsp;</span>
                    <router-link :to="{ path: '/top-blogs', query: $route.query }">
                        <a href="#" class="text-decoration-none text-dark d-none d-sm-flex">Xem TOP 10 bài viết</a>
                    </router-link>

                </div>

                <div class="d-sm-flex flex-wrap">
                    <div v-for="(post, index) in topPosts" :key="index" class="col-md-3 col-12 trending-card">
                        <CardVertical :title="post.title" :slug="post.slug" :imgSrc="post.image"
                            :readTime="calculateReadTime(post.content)" :author="post.user.name"
                            :authorName="post.user.username" :authorAvatar="post.user.avatar"
                            :createAt="formatDate(post.created_at)" :isSavePost="savedPosts.includes(post.id)"
                            @toggleSave="handelSavePost(post.id)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import Card from "../../components/cards/Card.vue";
import CardVertical from "../../components/cards/CardVertical.vue";
import { getUser, isLoggedIn } from "../../services/auth";
import { usePosts } from "../../services/post/usePosts";

export default {
    components: {
        Card,
        CardVertical
    },


    setup() {
        const { posts, loading, votes, upvotedPosts, handleUpvote, calculateReadTime, formatDate, handelSavePost, savedPosts } = usePosts('hot');
        const topPosts = ref([]);

        const fetchTopPosts = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/topPosts');
                topPosts.value = response.data.slice(0, 4);
            } catch (error) {
                console.error('Có lỗi xảy ra khi lấy bài viết:', error);
            }
        };
        onMounted(() => {
            fetchTopPosts();
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
            savedPosts,
            // top
            topPosts,

        };
    },

};
</script>

<style>
.homepage_trending {
    width: 100%;
    background-color: #fafafa;
}

.trending-card {
    padding-right: .5rem;
    padding-left: .5rem;
}
</style>
