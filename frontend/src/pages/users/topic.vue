<template>
    <div class="container-fluid">
        <h4 style="margin: 1.5rem 0;" class="fw-bold">CHỦ ĐỀ</h4>
        <div class="d-flex flex-wrap">

            <Category v-for="(topic, index) in (isMobile ? topics.slice(0, 2) : topics)" :key="index"
                :topicName="topic.name" @click="goToCategory(topic.slug)" />

            <Category v-for="(topic, index) in topics.slice(2)" :key="index + 2" :topicName="topic.name"
                v-show="showAll && isMobile" @click="goToCategory(topic.slug)" />
        </div>
        <a-button type="primary" size="large" shape="round" class="d-sm-none d-block" v-show="isMobile && !showAll"
            @click="toggleShowAll" style="background-color: #ff7919;">
            Hiển thị thêm
        </a-button>
    </div>
</template>

<script>
import Category from '../../components/TopicName.vue';
import { useRouter } from 'vue-router';
export default {
    components: {
        Category
    },
    data() {
        return {
            showAll: false,
            isMobile: false,
            topics: [],
        };
    },
    methods: {
        goToCategory(slug) {
            this.$router.push({ name: 'CategoryPage', params: { slug } });
        },
        toggleShowAll() {
            this.showAll = !this.showAll;
        },
        checkScreenSize() {
            this.isMobile = window.innerWidth <= 576;
        },
        async fetchTags() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/tags');
                this.topics = response.data;
            } catch (error) {
                console.error('Error fetching tags:', error);
            }
        }
    },
    mounted() {
        this.fetchTags();
        this.checkScreenSize();
        window.addEventListener('resize', this.checkScreenSize);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.checkScreenSize);
    }
}
</script>
