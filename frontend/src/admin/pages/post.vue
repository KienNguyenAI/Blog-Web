<template>
    <div class="shadow me-5 p-3">
        <a-list item-layout="horizontal" :data-source="data">
            <template #renderItem="{ item }">
                <a-list-item>
                    <template #actions>
                        <a key="list-loadmore-more" @click="info(item.status, item)">{{ item.status }}</a>
                        <a key="list-loadmore-more" :href="`/post/${item.slug}`">Đọc</a>
                        <a key="list-loadmore-edit" class="text-danger" @click="warning(item.slug)">Xóa</a>
                    </template>
                    <a-list-item-meta :description="item.user.name">
                        <template #title>
                            <a :href="`/post/${item.slug}`" target="_blank">{{ item.title }}</a>
                        </template>
                        <template #avatar>
                            <!-- <a-avatar src="https://joeschmoe.io/api/v1/random" /> -->
                        </template>

                    </a-list-item-meta>
                </a-list-item>
            </template>
        </a-list>
    </div>

</template>
<script setup>
import { ref, onMounted, h } from 'vue';
import { notification, Modal } from 'ant-design-vue';
const data = ref([]);


const fetchPost = async () => {
    try {
        const response = await axios.get('http://127.0.0.1:8000/api/getAllPost');
        data.value = response.data;
        console.log(response.data);
    } catch (error) {
        console.error('Error fetching users:', error);
    }
};

const deletePost = async (slug) => {
    try {
        const response = await axios.delete(`http://127.0.0.1:8000/api/delete/${slug}`);
        if (response.status === 200) {
            data.value = data.value.filter(post => post.slug !== slug);

            notification.success({
                message: 'Xóa bài viết thành công',
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
        title: 'Xóa bài viết',
        content: 'Bạn có chắc chắn muốn xóa bài viết này không?',
        okText: 'Xóa',
        okType: 'danger',
        cancelText: 'Hủy',
        onOk() {
            deletePost(slug);  // Xóa bài viết nếu người dùng chọn Xóa
        },
        onCancel() {
            console.log('Hủy bỏ xóa');

        }
    });

};

const info = (status, post) => {
    let title = '';
    let content = '';
    let newStatus = '';

    if (status === 'archived') {
        title = 'Công khai bài viết';
        content = 'Bạn có chắc chắn muốn công khai bài viết này không?';
        newStatus = 'published';
    } else if (status === 'published') {
        title = 'Lưu bài viết vào kho lưu trữ';
        content = 'Bạn có chắc chắn muốn lưu bài viết này vào kho lưu trữ không?';
        newStatus = 'archived';
    }

    Modal.confirm({
        title: title,
        content: content,
        cancelText: 'Hủy',
        okText: 'Xác nhận',
        onOk() {
            update(post, newStatus);
        },
        onCancel() {
            console.log('Hủy');
        }
    });
};
const update = async (post, newStatus) => {
    try {
        const slug = post.slug;
        const response = await axios.put(`http://127.0.0.1:8000/api/postSlug/${slug}`, {
            title: post.title,
            description: post.description,
            content: post.content,
            users_id: post.users_id,
            tags_id: post.tags_id,
            status: newStatus
        });
        if (response.status === 200) {
            const postIndex = data.value.findIndex(post => post.slug === slug);
            if (postIndex !== -1) {
                data.value[postIndex].status = newStatus;
            }

            notification.success({
                message: `Bài viết đã được chuyển sang trạng thái "${newStatus}" thành công.`,
                duration: 2,
                style: {
                    backgroundColor: '#f6ffed',
                }
            });
        }
    } catch (error) {
        console.error('Error updating post status:', error);
        notification.error({
            message: 'Có lỗi xảy ra khi cập nhật trạng thái bài viết.',
            duration: 2,
            style: {
                backgroundColor: '#fff2f0',
            }
        });
    }
};


onMounted(() => {
    fetchPost();
});
</script>