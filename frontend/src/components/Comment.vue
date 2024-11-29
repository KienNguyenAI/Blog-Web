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
                    <strong>{{ comment.author }}</strong>
                    <p class="mt-3">{{ comment.content }}</p>
                    <span class="reply" @click="startReply(comment.id)">Trả lời</span>

                    <!-- Show reply input field -->
                    <div v-if="comment.isReplying"
                        class="reply-form d-flex align-content-center justify-content-between">
                        <div class="form-control" contenteditable="true"
                            :placeholder="'Cảm nghĩ của bạn về comment này'" @input="updateReplyInput(comment.id)">
                        </div>
                        <span class="submit-comment p-2 ms-2" @click="submitReply(comment.id)">Trả lời</span>
                    </div>
                </div>

                <!-- Nested replies -->
                <div class="nested-comments" v-if="comment.replies.length > 0">
                    <div v-for="reply in comment.replies" :key="reply.id" class="comment">
                        <div class="comment-body">
                            <strong>{{ reply.author }}</strong>
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

<script>
export default {
    data() {
        return {
            commentInput: '', // To track the input value for new comment
            comments: [
                {
                    id: 1,
                    author: 'Nguyễn Văn A',
                    content: 'Bài viết rất hay!',
                    replies: [
                        {
                            id: 2,
                            author: 'Trần Thị B',
                            content: 'Cảm ơn bạn! Mình cũng rất thích bài viết này.'
                        }
                    ],
                    isReplying: false, // Track if the reply input should be shown
                    replyContent: '' // To track the reply content
                },
                {
                    id: 3,
                    author: 'Lê Thị C',
                    content: 'Rất thích chủ đề này, mong bài viết sau về chủ đề này!',
                    replies: [],
                    isReplying: false,
                    replyContent: '' // To track the reply content for this comment
                }
            ]
        };
    },
    methods: {
        updateCommentInput(event) {
            this.commentInput = event.target.innerText; // Get content from contenteditable div
        },
        updateReplyInput(commentId, event) {
            const comment = this.comments.find(c => c.id === commentId);
            comment.replyContent = event.target.innerText; // Get reply content
        },
        submitComment() {
            if (this.commentInput.trim() !== "") {
                const newComment = {
                    id: this.comments.length + 1,
                    author: 'Bạn',
                    content: this.commentInput,
                    replies: [],
                    isReplying: false,
                    replyContent: ''
                };
                this.comments.push(newComment);
                this.commentInput = ''; // Clear the input field after submission
            }
        },
        startReply(commentId) {
            const comment = this.comments.find(c => c.id === commentId);
            comment.isReplying = true;
        },
        submitReply(commentId) {
            const comment = this.comments.find(c => c.id === commentId);
            const replyContent = comment.replyContent.trim();
            if (replyContent) {
                const newReply = {
                    id: comment.replies.length + 1,
                    author: 'Bạn',
                    content: replyContent
                };
                comment.replies.push(newReply);
                comment.replyContent = ''; // Clear reply input after submission
                comment.isReplying = false; // Hide reply input after submission
            }
        }
    }
};
</script>
