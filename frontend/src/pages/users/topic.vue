<template>
    <div class="container-fluid">
        <h4 style="margin: 1.5rem 0;" class="fw-bold">CHỦ ĐỀ</h4>
        <div class="d-flex flex-wrap">

            <Category v-for="(topic, index) in (isMobile ? topics.slice(0, 2) : topics)" :key="index"
                :topicName="topic" />

            <Category v-for="(topic, index) in topics.slice(2)" :key="index + 2" :topicName="topic"
                v-show="showAll && isMobile" />
        </div>

        <a-button type="primary" size="large" shape="round" class="d-sm-none d-block" v-show="isMobile && !showAll"
            @click="toggleShowAll" style="background-color: #ff7919;">
            Hiển thị thêm
        </a-button>
    </div>
</template>

<script>
import Category from '../../components/TopicName.vue';

export default {
    components: {
        Category
    },
    data() {
        return {
            topics: [
                'Quan điểm - Tranh luận',
                'Chính trị - Xã hội',
                'Kinh tế - Thị trường',
                'Văn hóa - Giải trí',
                'Giáo dục - Đào tạo',
                'Sức khỏe - Y tế',
                'Môi trường - Thiên nhiên',
                'Công nghệ - Đổi mới',
                'Lịch sử - Di sản',
                'Du lịch - Khám phá',
                'Sáng tạo - Khởi nghiệp',
                'Thể thao - Giải trí',
                'Phong cách sống'
            ],
            showAll: false,
            isMobile: false,
        };
    },
    methods: {
        toggleShowAll() {
            this.showAll = !this.showAll;
        },
        checkScreenSize() {
            this.isMobile = window.innerWidth <= 576; // Kiểm tra nếu màn hình nhỏ hơn hoặc bằng 576px
        }
    },
    mounted() {
        this.checkScreenSize();
        window.addEventListener('resize', this.checkScreenSize); // Lắng nghe sự thay đổi kích thước màn hình
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.checkScreenSize); // Gỡ bỏ sự kiện khi component bị hủy
    }
}
</script>
