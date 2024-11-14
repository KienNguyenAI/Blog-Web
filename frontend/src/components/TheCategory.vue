<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-12">
                <Card />
                <div class="trending-carousel">
                    <!-- Nút mũi tên trái -->
                    <button class="carousel-arrow left-arrow" @click="prevSlide">
                        &lt;
                    </button>
                    <div class="wrapper">
                        <div class="carousel-slider">
                            <swiper ref="mySwiper" :space-between="30" :pagination="true" :slides-per-view="1"
                                :breakpoints="{
                                    320: { slidesPerView: 1 },  // Màn hình điện thoại hiển thị 1 slide
                                    768: { slidesPerView: 2 },  // Màn hình tablet hiển thị 2 slide
                                    1024: { slidesPerView: 3 }  // Màn hình desktop hiển thị 3 slide
                                }" @swiper="onSwiper">
                                <swiper-slide v-for="(card, index) in cardData" :key="index">
                                    <CardVertical :data="card" :isInSlider="true" />
                                </swiper-slide>
                            </swiper>
                        </div>
                    </div>
                    <!-- Nút mũi tên phải -->
                    <button class="carousel-arrow right-arrow" @click="nextSlide">
                        &gt;
                    </button>
                </div>
            </div>
            <div class="col-sm-4 d-sm-flex d-none">
                <div class="widget">
                    <div class="widget-body">
                        <div class="widget-title pb-4">
                            Quan điểm - Tranh luận
                        </div>
                        <div class="widget-content text-black">
                            <p><strong>Nội dung cho phép:</strong></p>
                            <p>Các nội dung thể hiện góc nhìn, quan điểm đa chiều về các vấn đề kinh tế, văn hoá – xã
                                hội trong và ngoài nước.</p>

                            <p><strong>Quy định:</strong></p>
                            <ul>
                                <li>Những nội dung không thuộc phạm trù của danh mục sẽ bị nhắc nhở và xoá (nếu không
                                    thay đổi thích hợp).</li>
                                <li>Nghiêm cấm spam, quảng cáo.</li>
                                <li>Nghiêm cấm post nội dung 18+ hay những quan điểm cực đoan liên quan tới chính trị -
                                    tôn giáo.</li>
                                <li>Nghiêm cấm phát ngôn thiếu văn hoá và đả kích cá nhân.</li>
                                <li>Nghiêm cấm bài đăng không ghi rõ nguồn nếu đi cóp nhặt.</li>
                            </ul>
                        </div>
                        <a-button size="large" style="width: 100%;">Theo dõi</a-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Card from './cards/Card.vue';
import CardVertical from './cards/CardVertical.vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/swiper-bundle.css';

export default {
    components: {
        Card,
        CardVertical,
        Swiper,
        SwiperSlide
    },
    data() {
        return {
            swiperInstance: null, // Lưu instance của swiper
            cardData: [
                { title: 'Card 1', description: 'Description 1' },
                { title: 'Card 2', description: 'Description 2' },
                { title: 'Card 3', description: 'Description 3' },
                { title: 'Card 4', description: 'Description 4' },
                { title: 'Card 5', description: 'Description 5' }
            ]
        };
    },
    methods: {
        // Lưu instance swiper khi nó được khởi tạo
        onSwiper(swiper) {
            this.swiperInstance = swiper;
        },

        // Chuyển tới slide tiếp theo
        nextSlide() {
            if (this.swiperInstance) {
                this.swiperInstance.slideNext();
            } else {
                console.error("Swiper chưa được khởi tạo!");
            }
        },

        // Chuyển tới slide trước
        prevSlide() {
            if (this.swiperInstance) {
                this.swiperInstance.slidePrev();
            } else {
                console.error("Swiper chưa được khởi tạo!");
            }
        }
    }
};
</script>

<style scoped>
.trending-carousel {
    position: relative;
    width: 100%;
    margin: auto;
    border: 1px solid #e8e8e8;
}

.wrapper {
    padding-left: 2rem;
}

.carousel-arrow {
    width: 2rem;
    height: 5rem;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: #bebebe;
    border: none;
    font-size: 24px;
    cursor: pointer;
    z-index: 10;
    padding: 0.5rem;
    opacity: 0.5;
    transition: opacity 0.3s;
    border: 1px solid white;
}

.carousel-arrow:hover {
    opacity: 0.8;
}

.left-arrow {
    left: 0;
    transform: translate(-50%, -50%);
}

.right-arrow {
    right: 0;
    transform: translate(50%, -50%);
}

.widget {
    margin-top: 1rem;
    margin-right: 1.5rem;
    margin-left: 1.5rem;
    justify-items: center;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e8e8e8;
    border-radius: .5rem;
}

.widget-body {
    padding: 3rem;

}

.widget-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.widget-content {
    font-size: 1rem;
    color: #555;
}

.widget-content ul {
    padding-left: 1.25rem;
    list-style-type: disc;
}

.widget-content li {
    margin-bottom: 0.5rem;
}
</style>
