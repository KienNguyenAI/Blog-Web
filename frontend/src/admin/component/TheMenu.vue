<template>
    <div class="ms-4">
        <a-menu class="shadow" id="dddddd" v-model:openKeys="openKeys" v-model:selectedKeys="selectedKeys"
            style="width: 256px" mode="inline" :items="menuItems" @click="handleClick" />
    </div>
</template>

<script setup>
import { reactive, ref, computed, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getCurrentInstance } from 'vue';

const selectedKeys = ref(['1']);
const openKeys = ref(['sub1']);
const route = useRoute();
const router = useRouter();

// Định nghĩa các mục menu từ routes
const menuItems = computed(() => {
    return [
        {
            key: 'grp',
            label: 'Quản lý',
            type: 'group',
            children: [
                {
                    key: 'users',
                    label: 'Tài khoản',
                    onClick: () => navigateTo('users')
                },
                {
                    key: 'posts',
                    label: 'Quản lý bài viết',
                    onClick: () => navigateTo('posts')
                },

                {
                    key: 'tags',
                    label: 'Quản lý tags',
                    onClick: () => navigateTo('tags')
                }
            ]
        }
    ];
});

const navigateTo = (path) => {
    router.push(`/admin/${path}`);
};


watch(() => route.path, (newPath) => {
    const path = newPath.split('/').pop();
    selectedKeys.value = [path];
});


</script>
