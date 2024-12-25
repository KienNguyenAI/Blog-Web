<template>
    <div class="card d-flex">
        <a :href="`/post/${slug}`" class="thumbnail">
            <img :src="imgSrc" alt="thumbnail" class="img-card">
        </a>
        <div class="card-bottom w-100">
            <div class="main">
                <div class="heading-contain d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <a :href="`/category/${cateSlug}`" class="text-decoration-none p-0">
                            <span class="category">{{ category }}</span>
                        </a>
                        <span style="color: #c3c3c3;">&emsp;|&emsp;</span>
                        <span class="time">{{ readTime }} phút đọc</span>
                    </div>
                    <div class="d-flex">
                        <i :class="['me-3', 'save-post', isSavePost ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark']"
                            style="color:#c3c3c3 ;cursor: pointer;" @click="toggleSave"></i>
                    </div>
                </div>

                <div class="content">
                    <div class="text">
                        <a href="" class="text-decoration-none">
                            <router-link :to="`/post/${slug}`" class="text-decoration-none">
                                <h1 class="title fw-bold">{{ title }}</h1>
                            </router-link>
                        </a>
                    </div>
                    <div class="description">
                        {{ description }}
                    </div>
                </div>
            </div>
            <div class="post-details d-flex justify-content-center align-items-center">
                <a :href="`/account/${name}`" class="me-3 p-0">
                    <img :src="avatar" alt="Avatar" class="rounded-circle" style="width: 3rem; height: 3rem;">
                </a>
                <div class="details">
                    <div class="author mb-1">
                        <a :href="`/account/${name}`" class="text-decoration-none text-black fw-bold p-0">{{ authorName
                            }}</a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="create-at">{{ createdAt }}</div>
                        <div class="interactions d-flex">
                            <div class="me-2 align-items-center">
                                <i class="me-1  fa-solid fa-caret-up fa-2xl upvote caret"
                                    :style="{ color: isUpvoted ? '#48bb78' : '#c3c3c3' }" @click="toggleUpvote"
                                    style="cursor: pointer;">
                                </i>
                                <span style="font-size: .75rem;">{{ voteCount }}</span>
                            </div>
                            <!-- <div class="me-2">
                                <i class="fa-regular fa-comment me-1"></i>
                                <span style="font-size: .75rem;">5</span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        imgSrc: String,
        category: String,
        cateSlug: String,
        readTime: Number,
        title: String,
        description: String,
        avatar: String,
        authorName: String,
        createdAt: String,
        slug: String,
        name: String,
        isUpvoted: Boolean,
        voteCount: Number,
        isSavePost: Boolean,

    },
    methods: {
        toggleUpvote() {
            this.$emit('toggleUpvote');
        },
        toggleSave() {
            this.$emit('toggleSave');
        }
    }
};
</script>

<style scoped>
@import url("@/style/card.css");
</style>
