<template>
    <div class="shadow p-3 rounded me-5">
        <a-table :dataSource="formattedDataSource" :columns="columns" />
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios'; // Đảm bảo bạn import axios

export default {
    setup() {
        const dataSource = ref([]);

        // Cột của bảng
        const columns = [
            {
                title: 'Tên tài khoản',
                dataIndex: 'username',
                key: 'username',
            },
            {
                title: 'Tên',
                dataIndex: 'name',
                key: 'name',
            },
            {
                title: 'Email',
                dataIndex: 'email',
                key: 'email',
            },
            {
                title: 'Vai trò',
                dataIndex: 'role',
                key: 'role',

            },
        ];


        const formattedDataSource = ref([]);


        const fetchUsers = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/users');


                formattedDataSource.value = response.data.map(user => ({
                    username: user.username,
                    name: user.name,
                    email: user.email,
                    role: user.role.name,
                }));
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        };

        onMounted(fetchUsers);

        return {
            formattedDataSource,
            columns,
        };
    },
};
</script>

<style scoped>
/* Các style tùy chỉnh cho bảng */
</style>
