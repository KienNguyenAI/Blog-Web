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
// import bioInfo from './bio/bioInfo.vue';
import Bio from './bio/Bio.vue';
import seriesInfo from './seriesInfo.vue';
import blockedUsers from './blockedUsers.vue';

export default {
    data() {
        return {
            tabs: ['Tài khoản', 'Tiểu sử'],
            selectedTab: 0
        };
    },
    computed: {

        currentTabComponent() {
            switch (this.selectedTab) {
                case 0:
                    return settingAccount;
                case 1:
                    return Bio;
                // case 2:
                //     return seriesInfo;
                // case 3:
                //     return blockedUsers;
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
    color: #ff7919;
    border-left: 3px solid #ff7919;
    padding-bottom: 10px;
    font-weight: bold;
}

.mod-tab li:hover {
    color: #ff7919;
}
</style>
