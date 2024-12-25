<template>
    <div class="comments p-5 mt-5 shadow">
        <div class="comment-form d-flex justify-content-between align-items-center">
            <div class="form-control" contenteditable="true" id="commentInput"
                placeholder="Hãy chia sẻ cảm nghĩ của bạn về bài viết" @input="updateCommentInput">
            </div>
            <span class="submit-comment p-2 ms-2" @click="submitComment">Gửi</span>
        </div>

        <div class="comment-tree mt-4">
            <div v-for="comment in comments" :key="comment.id" class="comment">
                <div class="comment-body">
                    <router-link :to="`/account/${comment.user.username}`">
                        <img alt="" :src="comment.user.avatar" class="rounded-circle me-3"
                            style="width: 2.5rem; height: 2.5rem;">
                        <strong class="text-black">{{ comment.user.name }}</strong>
                    </router-link>

                    <span v-if="comment.user.id === props.post.users_id" class="ms-3 text-primary"
                        style="font-size: .75rem;">Tác giả</span>

                    <p class="mt-3">{{ comment.content }}</p>
                    <span class="reply" @click="startReply(comment.id)">Trả lời</span>

                    <!-- Show reply input field -->
                    <div v-if="comment.isReplying"
                        class="reply-form d-flex align-content-center justify-content-between">
                        <div class="form-control" contenteditable="true"
                            :placeholder="'Cảm nghĩ của bạn về comment này'"
                            @input="updateReplyInput(comment.id, $event)">
                        </div>
                        <span class="submit-comment p-2 ms-2 d-flex align-items-center text-center"
                            @click="submitReply(comment.id)">
                            Trả lời
                        </span>
                    </div>
                </div>

                <div class="nested-comments" v-if="comment.replies.length > 0">
                    <div v-for="reply in comment.replies" :key="reply.id" class="comment">
                        <div class="comment-body">
                            <router-link :to="`/account/${reply.user.username}`">
                                <img alt="" :src="comment.user.avatar" class="rounded-circle me-3"
                                    style="width: 2.5rem; height: 2.5rem;">
                                <strong class="text-black">{{ reply.user.name }}</strong>
                            </router-link>

                            <span v-if="reply.user.id === props.post.users_id" class="ms-3 text-primary"
                                style="font-size: .75rem;">Tác giả</span>
                            <p class="mt-3">{{ reply.content }}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.form-control {
    width: 100%;
    outline: none;
    font-size: .875rem;
    min-height: 3rem;
    padding: 8px;
}

.form-control[placeholder]:empty::before {
    content: attr(placeholder);
    color: #aaa;
}

.submit-comment {
    display: inline-block;
    cursor: pointer;
}

.submit-comment:hover {
    background-color: #ffa25e;
    color: white;
    border-radius: .5rem;
}

.comment-tree {
    margin-top: 20px;
}

.comment {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.comment-body {
    margin-bottom: 5px;
}

.reply {
    color: #007bff;
    cursor: pointer;
    font-size: 0.875rem;
}

.reply:hover {
    text-decoration: underline;
}

.nested-comments {
    margin-left: 20px;
    padding-left: 20px;
    border-left: 2px solid #ccc;
}

.reply-form {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px dashed #ddd;
}
</style>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import { isLoggedIn, getUser } from '../services/auth';

const props = defineProps({
    post: Object
});

const commentInput = ref('');
const comments = reactive([]);
const user_id = ref(isLoggedIn() ? getUser().id : null);

const updateCommentInput = (event) => {
    commentInput.value = event.target.innerText;
};

const updateReplyInput = (commentId, event) => {
    const comment = comments.find(c => c.id === commentId);
    if (comment) {
        comment.replyContent = event.target.innerText;
    }
};

const submitComment = () => {
    if (commentInput.value.trim() !== "") {
        const newComment = {
            content: commentInput.value,
            post_id: props.post.id,
            user_id: user_id.value
        };


        axios.post('http://127.0.0.1:8000/api/comments', newComment)
            .then(response => {
                response.data.replies = [];
                comments.push(response.data);
                commentInput.value = '';
                document.getElementById('commentInput').innerText = '';
            })
            .catch(error => {
                console.error("Có lỗi xảy ra khi gửi bình luận", error);
            });
    }
};

const startReply = (commentId) => {
    const comment = comments.find(c => c.id === commentId);
    if (comment) {
        comment.isReplying = true;
    }
};

const submitReply = (commentId) => {
    const comment = comments.find(c => c.id === commentId);
    const replyContent = comment.replyContent.trim();
    if (replyContent) {
        const newReply = {
            content: replyContent,
            post_id: props.post.id,
            user_id: user_id.value,
            parent_id: commentId
        };
        axios.post('http://127.0.0.1:8000/api/comments', newReply)
            .then(response => {
                comment.replies.push(response.data);
                comment.replyContent = '';
                comment.isReplying = false;
            })
            .catch(error => {
                console.error("Có lỗi xảy ra khi gửi câu trả lời", error);
            });
    }
};


onMounted(() => {
    if (props.post && props.post.id) {
        axios.get(`http://127.0.0.1:8000/api/comments?post_id=${props.post.id}`)
            .then(response => {
                comments.push(...response.data);
            })
            .catch(error => {
                console.error("Có lỗi xảy ra khi tải các bình luận", error);
            });
    }
});

watch(() => props.post, (newPost) => {
    if (newPost && newPost.id) {
        axios.get(`http://127.0.0.1:8000/api/comments?post_id=${newPost.id}`)
            .then(response => {
                comments.length = 0; // Clear previous comments
                comments.push(...response.data);
            })
            .catch(error => {
                console.error("Có lỗi xảy ra khi tải các bình luận", error);
            });
    }
}, { immediate: true });
</script>
