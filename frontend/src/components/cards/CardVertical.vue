<template>
    <div class="card d-flex">
        <a :href="`/post/${slug}`" class="thumbnail">
            <img :src="imgSrc" alt="thumbnail" class="img-card">
        </a>
        <div class="card-bottom">
            <div class="main">
                <div class="heading-contain d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="time">{{ readTime }} phút đọc</span>
                    </div>
                    <div class="d-flex">
                        <i :class="['me-3', 'save-post', isSavePost ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark']"
                            style="color:#c3c3c3 ;cursor: pointer;" @click="toggleSave"></i>
                        <i class="fa-solid fa-ellipsis-vertical" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="content">
                    <div class="text">
                        <router-link :to="`/post/${slug}`" class="text-decoration-none">
                            <h1 class="title fw-bold">{{ title }}</h1>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="post-details d-flex justify-content-center align-items-center">
                <!-- Ẩn các phần tử này nếu là bài viết của chính người dùng -->
                <a :href="`/account/${authorName}`" class="me-sm-3 p-0" v-if="!isMyPost && !isInSlider">
                    <img :src="authorAvatar" alt="Avatar" class="rounded-circle avatar">
                </a>
                <div class="details ms-2">
                    <div class="author mb-1" v-if="!isMyPost">
                        <a :href="`/account/${authorName}`"
                            class="fw-bold text-decoration-none text-black p-0 author-name">{{ author }}</a>
                    </div>
                    <div class="d-flex justify-content-between" v-if="!isInSlider">
                        <div class="create-at">{{ createAt }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        slug: String,
        imgSrc: String,
        readTime: Number,
        author: String,
        authorName: String,
        authorAvatar: String,
        createAt: String,
        isSavePost: Boolean,
        isInSlider: {
            type: Boolean,
            default: false
        },
        isMyPost: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        toggleSave() {
            this.$emit('toggleSave');
        }
    }
}
</script>

<style scoped>
.card {
    width: 100%;
    display: flex;
    flex-direction: column;
    padding-top: 1.875rem;
    padding-bottom: 1.875rem;
}

.thumbnail {
    width: 100%;
    height: 11rem;
    overflow: hidden;
    margin-right: 1rem;
    padding: 0;
}

.img-card {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 0.025rem solid #dbdbdb;
    border-radius: .3rem;
}

.card-bottom {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    margin-top: .5rem;
}


.time {
    font-size: 0.75rem;
    color: #4d4d4d;
}


.title {
    font-size: 1.25rem;
    color: black;
    margin-bottom: .5rem;
    max-height: 3rem;
    overflow: hidden;
    text-overflow: ellipsis;
}

.details {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
}

.create-at {
    font-size: .75rem;
    color: #4d4d4d;
}

.avatar {
    width: 3rem;
    height: 3rem;
}

/* Media query cho màn hình nhỏ hơn 768px */
@media (max-width: 768px) {
    .card {
        flex-direction: row;
        padding-top: 1rem;
        padding-bottom: 1em;
    }

    .thumbnail {
        height: 6.25rem;
    }

    .title {
        font-size: .9375rem;
        max-height: 2rem;
    }

    .avatar {
        width: 2rem;
        height: 2rem;
    }

    .author-name {
        font-size: .75rem;
    }
}
</style>
