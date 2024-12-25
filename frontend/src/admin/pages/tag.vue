<template>
    <div class="shadow me-5 p-3">
        <a-button class="mb-3" @click="openAdd">Thêm tag</a-button>
        <a-list item-layout="horizontal" :data-source="data">
            <template #renderItem="{ item }">
                <a-list-item>
                    <template #actions>
                        <a key="list-loadmore-edit" class="text-danger" @click="warning(item.slug)">Xóa</a>
                    </template>
                    <a-list-item-meta>
                        <template #title>
                            <a :href="`/category/${item.slug}`" target="_blank">{{ item.name }}</a>
                        </template>
                        <template #avatar>
                            <!-- <a-avatar src="https://joeschmoe.io/api/v1/random" /> -->
                        </template>

                    </a-list-item-meta>
                </a-list-item>
            </template>
        </a-list>
    </div>
    <a-modal v-model:open="open" title="Thêm tag" @ok="handleOk">
        <a-input v-model:value="value" placeholder="Nhập tên tag" />
    </a-modal>
</template>
<script setup>
import { ref, onMounted, h } from 'vue';
import { notification, Modal } from 'ant-design-vue';
const data = ref([]);
const open = ref(false);
const value = ref('');
const openAdd = () => {
    open.value = true;
}

const handleOk = async () => {
    if (!value.value) {
        notification.error({
            message: 'Tên tag không thể để trống',
            duration: 2,
        });
        return;
    }
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/add', {
            name: value.value,

        });
        console.log(response.data);
        if (response.status === 201) {
            data.value.push(
                response.data[0]
            );

            open.value = false;
            value.value = '';

            notification.success({
                message: 'Thêm tag thành công',
                duration: 2,
                style: {
                    backgroundColor: '#f6ffed',
                }
            });
        }
    } catch (error) {
        console.error('Error adding tag:', error);
        notification.error({
            message: 'Có lỗi xảy ra khi thêm tag',
            duration: 2,
        });
    }
}

const fetchPost = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/tags');
        data.value = response.data;
        console.log(response.data);
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

const deletePost = async (slug) => {
    try {
        const response = await axios.delete(`http://127.0.0.1:8000/api/tags/slug/${slug}`);

        if (response.status === 200) {
            data.value = data.value.filter(post => post.slug !== slug);

            notification.success({
                message: 'Xóa thẻ thành công',
                duration: 2,
                style: {
                    backgroundColor: '#f6ffed',
                }
            });
        }

    } catch (error) {
        console.error('Error deleting post:', error);
    }
};

const warning = (slug) => {
    Modal.confirm({
        title: 'Xóa thẻ',
        content: 'Bạn có chắc chắn muốn thẻ này không?',
        okText: 'Xóa',
        okType: 'danger',
        cancelText: 'Hủy',
        onOk() {
            deletePost(slug);
        },
        onCancel() {
            console.log('Hủy bỏ xóa');

        }
    });

};




onMounted(() => {
    fetchPost();
});
</script>