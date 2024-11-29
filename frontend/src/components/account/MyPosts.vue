<template>
    <div class="container">
        <div class="row">
            <div v-for="(post, index) in visiblePosts" :key="post.id" class="col-md-4 mb-4">
                <CardVertical :title="post.title" :slug="post.slug" :imgSrc="post.image"
                    :readTime="calculateReadTime(post.content)" :createAt="formatDate(post.created_at)"
                    :isSavePost="false" :isMyPost="true" />
            </div>
        </div>

        <!-- Nút xem thêm -->
        <div v-if="posts.length > visiblePosts.length" class="text-center mt-4">
            <button class="btn btn-primary" @click="loadMorePosts">Xem thêm</button>
        </div>
    </div>
</template>



<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import CardVertical from '../cards/CardVertical.vue';
import { useRoute } from 'vue-router';

export default {
    components: {
        CardVertical
    },
    setup() {
        const posts = ref([]);
        const visiblePosts = ref([]);
        const route = useRoute();
        const username = route.params.username;

        const fetchPosts = async () => {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/posts/user/${username}`);
                posts.value = response.data;
                visiblePosts.value = posts.value.slice(0, 15);  // Hiển thị 15 bài viết đầu tiên
            } catch (error) {
                console.error('Lỗi khi lấy bài viết:', error);
            }
        };

        const calculateReadTime = (content) => {
            const wordsPerMinute = 200;
            const text = content.replace(/<[^>]*>/g, '');
            const wordCount = text.split(/\s+/).length;
            return Math.ceil(wordCount / wordsPerMinute);
        };

        const formatDate = (dateString) => {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            return `${day} Tháng ${month}`;
        };

        const loadMorePosts = () => {
            const nextPosts = posts.value.slice(visiblePosts.value.length, visiblePosts.value.length + 15);
            visiblePosts.value.push(...nextPosts);
        };

        onMounted(() => {
            fetchPosts();
        });

        return {
            posts,
            visiblePosts,
            calculateReadTime,
            formatDate,
            loadMorePosts
        };
    }
};
</script>

<style scoped>
.row {
    display: flex;
    flex-wrap: wrap;
}

.col-sm-4 {
    flex: 1 0 30%;
    /* Điều chỉnh độ rộng cột để linh hoạt */
    margin-bottom: 16px;
}

.mb-4 {
    margin-bottom: 1.5rem;
}
</style>
