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
            <!-- <a href="#" class="item follow" :class="{ active: selectedItem === 'DÀNH CHO BẠN' }"
                @click.prevent="selectItem('DÀNH CHO BẠN', 'follow')">
                <HeartOutlined class="icon" />
                <span class="text">THEO TÁC GIẢ</span>
            </a> -->
            <a href="#" class="item top" :class="{ active: selectedItem === 'TOP' }"
                @click.prevent="selectItem('TOP', 'top')">
                <CrownOutlined class="icon" />
                <span class="text">TOP</span>
            </a>
        </div>
    </div>

    <div class="card-gallery">
        <hot v-if="selectedItem === 'THỊNH HÀNH'" />
        <newPosts v-if="selectedItem === 'MỚI'" />
        <follow v-if="selectedItem === 'DÀNH CHO BẠN'" />
        <top v-if="selectedItem === 'TOP'" />
    </div>
</template>

<script>
import { FireOutlined, StarOutlined, HeartOutlined, CrownOutlined } from '@ant-design/icons-vue';

import hot from './hot.vue';
import newPosts from './new.vue';
import follow from './follow.vue';
import top from './top.vue';

export default {
    components: {
        FireOutlined,
        StarOutlined,
        HeartOutlined,
        CrownOutlined,
        hot,
        newPosts,
        follow,
        top
    },
    data() {
        return {
            selectedItem: 'THỊNH HÀNH'
        };
    },
    methods: {
        selectItem(item, sort) {
            this.selectedItem = item;
            this.$router.push({ query: { sort: sort } });
        }
    },
    watch: {
        '$route.query.sort': function (newSort) {
            switch (newSort) {
                case 'hot':
                    this.selectedItem = 'THỊNH HÀNH';
                    break;
                case 'new':
                    this.selectedItem = 'MỚI';
                    break;
                case 'follow':
                    this.selectedItem = 'DÀNH CHO BẠN';
                    break;
                case 'top':
                    this.selectedItem = 'TOP';
                    break;
                default:
                    this.selectedItem = 'THỊNH HÀNH';
            }
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
    border-left: 3px solid #ff7919;
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
    color: #ff7919;
}

.item.active .text {
    color: #ff7919;
}

.item.active {
    border-bottom: 3px solid #ff7919;
    padding-bottom: 10px;
}

.card-gallery {
    margin-top: 3rem;
}

/* màu blue #0090d4 */
@media (max-width: 768px) {
    .filter {
        display: none;
    }
}
</style>
