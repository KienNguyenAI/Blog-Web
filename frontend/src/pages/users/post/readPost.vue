<template>

    <div class="post-container">
        <div class="auth-container">
            <div class="category">

            </div>
            <div class="title">
                {{ post.title }}
            </div>
            <div class="description">
                {{ post.description }}
            </div>
            <div class="create-profile mt-3 d-flex ">
                <a href="" class="me-3 p-0">
                    <img src="@/assets/avatars/default.webp" alt="Avatar" class="rounded-circle"
                        style="width: 3rem; height: 3rem;">
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
                        <i class="fa-solid fa-ellipsis-vertical fa-lg ant-dropdown-link" style="cursor: pointer;"></i>
                        <template #overlay>
                            <a-menu class="p-3">
                                <span class="p-1" style="cursor: pointer;">Chặn người dùng</span>
                            </a-menu>
                        </template>
                    </a-dropdown>
                </div>
            </div>

        </div>
        <div class="post-content pt-3" ref="postContentRef" v-html="renderedContent">

        </div>
        <div class="sticky-bar" v-show="showStickyBar">
            <div>a</div>
            <div>b</div>
        </div>
        <div class="post-tool-bar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-caret-up fa-2xl upvote" :class="{ 'active': isCaretUpActive }"
                    @click="handleVote('up')">
                </i>
                <span class="me-2 ms-2">{{ upVotes - downVotes }}</span>
                <i class="fa-solid fa-caret-down fa-2xl downvote" :class="{ 'active': isCaretDownActive }"
                    @click="handleVote('down')">
                </i>
            </div>
            <div class="d-flex align-items-center">
                <i :class="isBookmarked ? 'fa-solid fa-bookmark fa-lg' : 'fa-regular fa-bookmark fa-lg'"
                    @click="toggleBookmark">
                </i>
            </div>
        </div>

        <div class="post-subscription">

        </div>
        <div class="comment-container">

        </div>
        <button v-show="showScrollTopButton" class="scroll-top-button" @click="scrollToTop">
            <i class="fa-solid fa-chevron-up fa-lg"></i>
        </button>
    </div>

</template>

<script>
import useReadPost from '../../../services/readPost';

export default {
    setup() {
        return useReadPost();
    },
};
</script>
<style>
.post-container {
    max-width: 45rem;
    margin: 0 auto;
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

.post-tool-bar i {
    cursor: pointer;
    color: #d8d8d8;
}

.post-tool-bar .upvote.active {

    color: #48bb78;
}

.post-tool-bar .downvote.active {

    color: #f56565;
}

.fa-bookmark {
    cursor: pointer;
    color: #d8d8d8;

    transition: color 0.3s ease;
}

.fa-bookmark.fa-solid {
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