<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-2 col-12">
                <div class="mod-tab">
                    <ul>
                        <li v-for="(item, index) in tabs" :key="index" :class="{ 'active': selectedTab === index }"
                            @click="selectTab(index)">
                            {{ item }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-8 col-12">
                <component :is="currentTabComponent"></component>
            </div>
        </div>
    </div>
</template>

<script>
import settingAccount from './accountInfo.vue';
import bioInfo from './bioInfo.vue';
import seriesInfo from './seriesInfo.vue';
import blockedUsers from './blockedUsers.vue';

export default {
    data() {
        return {
            tabs: ['Tài khoản', 'Tiểu sử', 'Series', 'Đã Chặn'],
            selectedTab: 0
        };
    },
    computed: {

        currentTabComponent() {
            switch (this.selectedTab) {
                case 0:
                    return settingAccount;
                case 1:
                    return bioInfo;
                case 2:
                    return seriesInfo;
                case 3:
                    return blockedUsers;
                default:
                    return settingAccount; // Mặc định
            }
        }
    },
    methods: {
        selectTab(index) {
            this.selectedTab = index;
        }
    }
};
</script>

<style>
.mod-tab ul {
    list-style: none;
    padding: 0;
}

.mod-tab li {
    cursor: pointer;
    padding: .75rem;
    display: flex;
    align-items: center;
    font-size: 1rem;
}

.mod-tab li.active {
    color: #0090d4;
    border-left: 3px solid #0090d4;
    padding-bottom: 10px;
    font-weight: bold;
}

.mod-tab li:hover {
    color: #0090d4;
}
</style>
