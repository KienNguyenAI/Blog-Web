<template>

    <div class="post-container pe-1 ps-1 ">
        <div class="auth-container">
            <div class="category">
                <a href="" class="tag">{{ tags.name }}</a>
            </div>
            <div class="title">
                {{ post.title }}
            </div>
            <div class="description">
                {{ post.description }}
            </div>
            <div class="create-profile mt-3 d-flex ">
                <a :href="`/account/${author.username}`" class="me-3 p-0">
                    <img :src="author.avatar" alt="Avatar" class="rounded-circle" style="width: 3rem; height: 3rem;">
                </a>
                <div class="details">
                    <div class="author mb-1 ">
                        <a :href="`/account/${author.username}`" class="text-decoration-none text-black fw-bold p-0">{{
                            author.name }}</a>
                    </div>
                    <div class="d-flex justify-content-between" style="color: #a0aec0;">
                        <div class="create-at">{{ formattedDate }}</div>
                    </div>

                </div>
                <div class="more justify-content-end ms-auto">
                    <a-dropdown :trigger="['click']" placement="bottomRight">
                        <i v-if="userId !== author.id" class="fa-solid fa-ellipsis-vertical fa-lg ant-dropdown-link"
                            style="cursor: pointer;"></i>
                        <template #overlay>
                            <a-menu class="p-3">
                                <span class="p-1" style="cursor: pointer;">Chặn người dùng</span>
                            </a-menu>
                        </template>
                    </a-dropdown>
                    <div class="d-flex align-items-center justify-content-center">
                        <div v-if="userId === author.id" class="btn-delete me-2" @click="showModal">Xóa</div>
                        <div v-if="userId === author.id" class="btn-update" @click="updatePost">Cập nhật</div>
                    </div>


                    <a-modal v-model:open="open" title="Xóa bài viết" @ok="deletePost">
                        Sẽ không có cách nào hoàn tác lại hành động này. Bạn có chắc chắn muốn xóa bài viết?
                    </a-modal>
                </div>
            </div>

        </div>
        <div class="post-content pt-3 " ref="postContentRef" v-html="renderedContent">

        </div>
        <div class="sticky-bar align-items-center " v-show="showStickyBar">
            <i class="fa-solid fa-caret-up fa-2xl upvote mb-3 caret"
                :class="{ 'active': isCaretUpActive || (userId === author.id) }"
                @click="userId !== author.id && handleVote('up')">
            </i>
            <span class="me-2 ms-2 mb-3">{{ voteCount }}</span>
            <i class="fa-solid fa-caret-down fa-2xl downvote caret" :class="{ 'active': isCaretDownActive }"
                @click="userId !== author.id && handleVote('down')">
            </i>

            <a href="" class="avatar-container mt-3 p-0">
                <img :src="author.avatar" alt="Avatar" class="rounded-circle" style="width: 3rem; height: 3rem;">
            </a>
            <div class=" mt-3" v-if="userId !== author.id">
                <i :class="isBookmarked ? 'fa-solid fa-bookmark fa-lg ' : 'fa-regular fa-bookmark fa-lg'"
                    @click="toggleBookmark">
                </i>
            </div>
        </div>
        <div class="post-tool-bar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-caret-up fa-2xl upvote caret"
                    :class="{ 'active': isCaretUpActive || (userId === author.id) }" :disabled="userId === author.id"
                    @click="userId !== author.id && handleVote('up')">
                </i>
                <span class="me-2 ms-2">{{ voteCount }}</span>
                <i class="fa-solid fa-caret-down fa-2xl downvote caret" :class="{ 'active': isCaretDownActive }"
                    @click="userId !== author.id && handleVote('down')">
                </i>

            </div>
            <div class="d-flex align-items-center" v-if="userId !== author.id">
                <i :class="isBookmarked ? 'fa-solid fa-bookmark fa-lg' : 'fa-regular fa-bookmark fa-lg'"
                    @click="toggleBookmark">
                </i>
            </div>
        </div>

        <hr class="divider" />

        <div class="post-subscription ">
            <div class="row">
                <div class="col-sm-6 col-12 p-0 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <a href="" class="me-3 p-0">
                            <img :src="author.avatar" alt="Avatar" class="rounded-circle"
                                style="width: 3rem; height: 3rem;">
                        </a>
                        <div class="details ">
                            <div class="author mb-1 ">
                                <a :href="`/account/${author.username}`"
                                    class="text-decoration-none text-black fw-bold p-0">{{
                                        author.name }}</a>
                            </div>
                            <div class="d-flex justify-content-between" style="color: #a0aec0;">
                                <div class="create-at">{{ formattedDate }}</div>
                            </div>
                        </div>
                    </div>
                    <div v-if="userId !== author.id">
                        <div class="btn-follow" v-if="!isFollowing" @click="followUser">Theo dõi</div>
                        <div class="btn-following" v-else @click="unfollowUser">Đang Theo dõi</div>
                    </div>

                </div>
                <div class="col-sm-6 col-12 pe-0">

                </div>
            </div>
        </div>
        <div class="comment-container">

        </div>
        <button v-show="showScrollTopButton" class="scroll-top-button" @click="scrollToTop">
            <i class="fa-solid fa-chevron-up fa-lg"></i>
        </button>

        <div class="post-comment mt-5">
            <Comment :post="post" />
        </div>
    </div>

</template>

<script>
import useReadPost from '../../../services/post/readPost';
import Comment from '../../../components/Comment.vue';
export default {
    components: {
        Comment,
    },
    setup() {
        return useReadPost();
    },

};
</script>
<style>
.post-container {
    max-width: 45rem;
    margin: 0 auto;
    margin-top: 5rem;
}

.post-container .divider {
    border: none;
    border-top: 1px solid #ddd;
    margin: 1rem 0;
    width: 100%;
}

.post-container .btn-update,
.post-container .btn-delete {
    background-color: #f56565;
    padding: .5rem 1rem;
    border-radius: .5rem;
    color: white;
    cursor: pointer;
}

.post-container .btn-update {
    background-color: #48bb78;
}

.post-subscription {
    font-size: 0.875rem;
}

.post-subscription .btn-follow,
.post-subscription .btn-following {
    padding: .5rem 1rem;
    border: 1px solid #d8d8d8;
    border-radius: .5rem;
    cursor: pointer;

}

.post-subscription .btn-following {
    background-color: #ff7919;
    color: white;
}

.auth-container {
    padding: 1rem .75rem;
}

.auth-container .title {
    color: #2d3748;
    min-height: 2rem;
    padding: 0.5rem 0;
    font-size: 2.625rem;
    font-weight: 500;
    margin-bottom: 1rem;
}

.auth-container .description {
    color: #a0aec0;
    font-style: italic;
}

.auth-container .category .tag {
    color: #a0aec0;
    padding: 0;
    font-size: .875rem;
}

.auth-container .category .tag:hover {
    text-decoration: underline;
}

.create-profile {
    font-size: 0.875rem;
    align-items: center
}

.post-content {
    font-family: "Noto Serif", Regular, Times New Roman;

}

figure {
    display: flex;
    flex-direction: column;
    align-items: center;
}

figcaption {
    padding: 0.625rem 0.75rem;
    font-size: 1.1rem;
}

.sticky-bar {
    position: fixed;
    display: flex;
    flex-direction: column;
    top: 50%;
    left: 20%;
    transition: transform 0.3s ease-in-out;

}



.caret {
    cursor: pointer;
    color: #d8d8d8;
}

.upvote.active {

    color: #48bb78;
}

.downvote.active {

    color: #f56565;
}

.post-container .fa-bookmark {
    cursor: pointer;
    color: #d8d8d8;

    transition: color 0.3s ease;
}

.post-container .fa-bookmark.fa-solid {
    color: #48bb78;

}

.scroll-top-button {
    position: fixed;
    bottom: 3rem;
    right: 5rem;
    background-color: #ffa25e;
    color: white;
    border: none;
    border-radius: 50%;
    padding: .8rem .8rem;
    font-size: 1rem;
    cursor: pointer;
    z-index: 1000;
}

@media (max-width: 768px) {
    .sticky-bar {
        display: none;
    }

}
</style>