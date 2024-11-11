<template>
    <div class="filter-bar d-flex justify-content-between align-items-center">
        <div class="title">
            <span class="custom-title">DÀNH CHO BẠN</span>
        </div>
        <div class="filter">
            <a href="#" class="item hot" :class="{ active: selectedItem === 'THỊNH HÀNH' }"
                @click.prevent="selectItem('THỊNH HÀNH', 'hot')">
                <FireOutlined class="icon" />
                <span class="text">THỊNH HÀNH</span>
            </a>
            <a href="#" class="item new" :class="{ active: selectedItem === 'MỚI' }"
                @click.prevent="selectItem('MỚI', 'new')">
                <StarOutlined class="icon" />
                <span class="text">MỚI</span>
            </a>
            <a href="#" class="item follow" :class="{ active: selectedItem === 'DÀNH CHO BẠN' }"
                @click.prevent="selectItem('DÀNH CHO BẠN', 'follow')">
                <HeartOutlined class="icon" />
                <span class="text">THEO TÁC GIẢ</span>
            </a>
            <a href="#" class="item top" :class="{ active: selectedItem === 'TOP' }"
                @click.prevent="selectItem('TOP', 'top')">
                <CrownOutlined class="icon" />
                <span class="text">TOP</span>
            </a>
        </div>
    </div>

    <div class="card-gallery">
        <Card />
        <Card />
        <Card />
        <Card />
    </div>
</template>

<script>
import { FireOutlined, StarOutlined, HeartOutlined, CrownOutlined } from '@ant-design/icons-vue';
import Card from './Card.vue';

export default {
    components: {
        FireOutlined,
        StarOutlined,
        HeartOutlined,
        CrownOutlined,
        Card
    },
    data() {
        return {
            selectedItem: 'THỊNH HÀNH'
        };
    },
    methods: {
        selectItem(item, sort) {
            this.selectedItem = item;
            this.$router.push({ path: '/', query: { sort: sort } });
        }
    }
};
</script>




<style>
a {
    text-decoration: none;
    padding-left: .75rem;
    padding-right: .75rem;
}

.filter-bar {
    border-bottom: 1.25px solid #e0e0e0;
    padding-bottom: 10px;
    margin-top: 1rem;
    margin-bottom: 1rem;
}

.custom-title {
    border-left: 3px solid #0090d4;
    font-weight: bold;
    padding-left: 10px;
}

.text {
    color: black;
    font-size: .875rem;
}

.text:hover {
    color: #898989;
}

/* Màu icon mặc định */
.icon {
    color: #898989;
    font-size: 1rem;
    margin-right: .5rem;
}

.item.active .icon {
    color: #0090d4;
}

.item.active .text {
    color: #0090d4;
}

.item.active {
    border-bottom: 3px solid #0090d4;
    padding-bottom: 10px;
}

.card-gallery {
    margin-top: 3rem;
}

@media (max-width: 768px) {
    .filter {
        display: none;
    }
}
</style>
