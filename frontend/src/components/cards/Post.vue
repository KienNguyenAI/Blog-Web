<template>
    <div class="container">
        <div class="post-container">
            <!-- /tag/{slug} -->
            <div class="d-flex align-items-center">
                <a class="text-decoration-none p-0" :href="`/category/${cateSlug}`">
                    <span class="category text-black">{{ category }}</span>
                </a>
                <span style="color: #c3c3c3;">&emsp;|&emsp;</span>
                <span class="time">{{ readTime }} phút đọc</span>
            </div>
            <div class="post-title">

                <router-link :to="`/post/${slug}`" class=" p-0 text-black text-decoration-none">
                    <span class="title fw-bold">{{ title }}</span>
                </router-link>
            </div>
            <img :src="imgSrc" alt="" class="img-post">
            <div class="editor" v-html="renderedContent"></div>
            <div class="post-read-info d-flex mb-3">

                <a :href="`/post/${slug}`" class="text-primary p-0 ">
                    <span>Đọc tiếp</span>
                    <span style="color: #c3c3c3;">&emsp;|&emsp;</span>
                    <span>{{ readTime }} phút đọc</span>
                </a>

            </div>
            <div class="d-flex justify-content-between">
                <div class="interactions d-flex">
                    <div class="me-2">
                        <i class="me-1  fa-solid fa-caret-up fa-2xl upvote caret"
                            :style="{ color: isUpvoted ? '#48bb78' : '#c3c3c3' }" @click="toggleUpvote"
                            style="cursor: pointer;">
                        </i>
                        <span style="font-size: .75rem;">{{ voteCount }}</span>
                    </div>
                    <!-- <div class="me-2">
                        <i class="fa-regular fa-eye me-1"></i>
                        <span style="font-size: .75rem;">{{ viewCount }}</span>
                    </div>
                    <div class="me-2">
                        <i class="fa-regular fa-comment me-1"></i>
                        <span style="font-size: .75rem;">{{ commentCount }}</span>
                    </div> -->
                </div>
                <div class="d-flex">
                    <i :class="['me-3', 'save-post', isSavePost ? 'fa-solid fa-bookmark' : 'fa-regular fa-bookmark']"
                        style="color:#c3c3c3 ;cursor: pointer;" @click="toggleSave"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';
export default {
    props: {
        category: String,
        cateSlug: String,
        title: String,
        slug: String,
        imgSrc: String,
        readTime: Number,
        isUpvoted: Boolean,
        voteCount: Number,
        viewCount: Number,
        commentCount: Number,
        content: String,
        isSavePost: Boolean
    },
    methods: {
        toggleUpvote() {
            this.$emit('toggleUpvote');
        },
        toggleSave() {
            this.$emit('toggleSave');
        }
    },
    setup(props) {

        const renderedContent = computed(() => {
            try {
                const contentArray = JSON.parse(props.content || '[]');
                return contentArray
                    .map((item) => {
                        if (typeof item === 'string') {
                            return item;
                        } else {
                            return '';
                        }
                    })
                    .join('');
            } catch (error) {
                return 'Nội dung không hợp lệ';
            }
        });

        return { renderedContent };
    }
};

</script>

<style scoped>
.post-container {
    margin-right: 15.5rem;
    margin-left: 15.5rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e8e8e8;
}

.category,
.time {
    font-size: 0.75rem;
    color: #4d4d4d;
}

.category:hover {
    font-weight: bold;
}

.post-title {
    margin-top: 1rem;
    margin-bottom: 1rem;

}

.post-title .title {
    font-size: 2rem;
    font-weight: bold;
    color: black;
    padding: 0;
}

.editor {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    -webkit-line-clamp: 10;
    text-overflow: ellipsis;
    line-height: 1.6;
    max-height: 20rem;
}

.img-post {
    max-width: 100%;
    height: auto;
}

.post-read-info {
    margin-top: 1rem;
    font-size: 1rem;
}

@media (max-width: 768px) {
    .post-container {
        margin: 0;
        margin-top: 2rem;
    }

    .post-title {
        font-size: 1.5rem;
    }

    .post-read-info span {
        font-size: 1rem;
    }
}
</style>