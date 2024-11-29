<template>
    <div>
        <div class="container">
            <h2 class="top-blog-heading"># TOP 10 BÀI VIẾT NỔI BẬT</h2>
        </div>

        <div v-if="posts.length > 0">
            <Post v-for="post in posts" :key="post.id" :category="post.tag.name" :title="post.title" :slug="post.slug"
                :cateSlug="post.tag.slug" :imgSrc="post.image" :readTime="calculateReadTime(post.content)"
                :isUpvoted="upvotedPosts.includes(post.id)" @toggleUpvote="handleUpvote(post.id)"
                :voteCount="votes[post.id]" :viewCount="post.view_count" :commentCount="post.comment_count"
                :content="post.content" :isSavePost="savedPosts.includes(post.id)"
                @toggleSave="handelSavePost(post.id)" />
        </div>
        <div v-else>
            <p>Đang tải...</p>
        </div>
    </div>
</template>

<script>

import { isLoggedIn, getUser } from '../../services/auth';
import axios from 'axios';
import Post from '../../components/cards/Post.vue';
import { notification } from 'ant-design-vue';
export default {
    components: {
        Post
    },
    data() {
        return {
            posts: [],
            upvotedPosts: [],
            votes: {},
            savedPosts: [],
            userId: isLoggedIn() ? getUser().id : null

        };
    },
    mounted() {
        this.fetchTopPosts();
        this.fetchUserUpvotes();
    },
    methods: {

        fetchTopPosts() {
            axios.get('http://127.0.0.1:8000/api/topPosts')
                .then(response => {
                    this.posts = response.data;
                    this.posts.forEach(post => {
                        this.votes[post.id] = post.votes_count;
                    });
                })
                .catch(error => {
                    console.error('Có lỗi xảy ra khi lấy bài viết:', error);
                });
        },
        fetchUserUpvotes() {
            axios.get(`http://127.0.0.1:8000/api/user/${this.userId}/upvotes`)
                .then(response => {
                    this.upvotedPosts = response.data.map(post => post.id);
                })
                .catch(error => {
                    console.error("Lỗi khi lấy danh sách bài viết đã upvoted:", error);
                });
        },
        calculateReadTime(content) {
            const wordsPerMinute = 200;
            const text = content.replace(/<[^>]*>/g, '');
            const wordCount = text.split(/\s+/).length;
            return Math.ceil(wordCount / wordsPerMinute);
        },
        handleUpvote(postId) {
            console.log(postId)
            const alreadyUpvoted = this.upvotedPosts.includes(postId);
            try {
                axios.post('http://127.0.0.1:8000/api/votes', {
                    vote_type: 'up',
                    post_id: postId,
                    user_id: this.userId,
                })
                    .then(() => {
                        if (alreadyUpvoted) {
                            this.upvotedPosts = this.upvotedPosts.filter(id => id !== postId);
                            this.votes[postId]--;
                        } else {
                            this.upvotedPosts.push(postId);
                            this.votes[postId]++;
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi khi xử lý 'upvote':", error);
                    });
            } catch (error) {
                console.error("Lỗi khi xử lý 'upvote':", error);
            }
        },
        handelSavePost(postId) {
            const alreadySavePost = this.savedPosts.includes(postId); // Sửa lỗi: không cần .value
            try {
                axios.post('http://127.0.0.1:8000/api/savePost', {
                    users_id: this.userId, // Sửa lỗi: dùng this.userId thay vì userId
                    posts_id: postId
                })
                    .then(() => {
                        if (alreadySavePost) {
                            // Bỏ lưu bài viết
                            this.savedPosts = this.savedPosts.filter(id => id !== postId);
                            notification.success({
                                message: `Đã bỏ lưu bài viết`,
                                duration: 1,
                                style: {
                                    backgroundColor: '#f6ffed',
                                }
                            });
                        } else {

                            this.savedPosts.push(postId);
                            notification.success({
                                message: `Đã lưu bài viết`,
                                duration: 1,
                                style: {
                                    backgroundColor: '#f6ffed',
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi khi lưu bài viết:", error);
                    });
            } catch (error) {
                console.error("Lỗi khi lưu bài viết:", error);
            }
        }



    }
};
</script>

<style>
.top-blog-heading {
    text-align: left;
    font-size: 2.5rem;
    padding: 1rem;
    margin-right: 15.5rem;
    margin-left: 15.5rem;
    border-bottom: 1px solid #e8e8e8;
}

@media (max-width: 768px) {
    .top-blog-heading {
        margin: 0;
        font-size: 1rem;
        margin-top: 2rem;
    }
}
</style>
