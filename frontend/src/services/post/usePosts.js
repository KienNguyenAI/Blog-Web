import { ref, onMounted } from 'vue';
import axios from 'axios';
import { getUser, isLoggedIn } from '../auth';
import { notification } from 'ant-design-vue';

export function usePosts(sort) {
    const posts = ref([]);
    const loading = ref(true);
    const votes = ref({});
    const upvotedPosts = ref([]);
    const savedPosts = ref([]);
    const userId = isLoggedIn() ? getUser().id : null;

    const fetchPosts = async () => {
        try {
            const response = await axios.get(`http://127.0.0.1:8000/api/getPosts/${sort}`, {
                params: { userId: userId }
            });
            posts.value = response.data;

            posts.value.forEach(post => {
                votes.value[post.id] = post.votes_count;
                if (post.is_saved) savedPosts.value.push(post.id);
            });

            console.log(savedPosts.value);
            fetchUserUpvotes();
        } catch (error) {
            console.error('Lỗi khi lấy bài viết:', error);
        } finally {
            loading.value = false;
        }
    };


    const fetchUserUpvotes = async () => {
        try {
            if (userId) {
                const response = await axios.get(`http://127.0.0.1:8000/api/user/${userId}/upvotes`);
                upvotedPosts.value = response.data.map(post => post.id); // Lưu bài viết đã upvoted
            }
        } catch (error) {
            console.error("Lỗi khi lấy danh sách bài viết đã upvoted:", error);
        }
    };

    const handleUpvote = async (postId) => {
        const alreadyUpvoted = upvotedPosts.value.includes(postId);
        try {
            await axios.post('http://127.0.0.1:8000/api/votes', {
                vote_type: 'up',
                post_id: postId,
                user_id: userId,
            });
            if (alreadyUpvoted) {
                upvotedPosts.value = upvotedPosts.value.filter(id => id !== postId);
                votes.value[postId]--;
            } else {
                upvotedPosts.value.push(postId);
                votes.value[postId]++;
            }
        } catch (error) {
            console.error("Lỗi khi xử lý 'upvote':", error);
        }
    };

    // Trong usePosts.js
    const handelSavePost = async (postId) => {
        const alreadySavePost = savedPosts.value.includes(postId)
        try {
            await axios.post('http://127.0.0.1:8000/api/savePost', {
                users_id: userId,
                posts_id: postId
            });
            if (alreadySavePost) {
                savedPosts.value = savedPosts.value.filter(id => id !== postId);
                notification.success({
                    message: `Đã bỏ lưu bài viết`,
                    duration: 1,
                    style: {
                        backgroundColor: '#f6ffed',
                    }
                });
            } else {
                savedPosts.value.push(postId);
                notification.success({
                    message: `Đã lưu bài viết`,
                    duration: 1,
                    style: {
                        backgroundColor: '#f6ffed',
                    }
                });
            }


        } catch (error) {
            console.error("Lỗi khi lưu bài viết:", error);
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

    onMounted(() => {
        fetchPosts();
    });

    return {
        posts,
        loading,
        votes,
        upvotedPosts,
        handleUpvote,
        savedPosts,
        handelSavePost,
        calculateReadTime,
        formatDate
    };
}
