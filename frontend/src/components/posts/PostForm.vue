<template>
    <form action="" @submit.prevent="upPosts">
        <div class="post-form">
            <div class="title" contenteditable="true" @input="handleInput" :text-content="title"
                placeholder="Tiêu đề bài viết.....">
            </div>


            <div class="editor">
                <div class="codex-editor " style="padding-bottom: 20rem;">
                    <CeBlock ref="ceBlockRef" />

                </div>
            </div>
            <div class="next-step">


                <!-- Nút mở modal -->
                <button type="button" class="button" @click="showModal">Bước tiếp theo</button>

                <!-- Modal -->
                <a-modal v-model:open="open">
                    <div>
                        <label for="" class="fw-bold">Mô tả bài viết </label>
                        <a-textarea v-model:value="description" :rows="4" />
                    </div>
                    <template #footer>
                        <div class="d-flex justify-content-center align-items-center modal-footer">
                            <button type="button" @click="open = false" class="btn-cancel me-3">Quay lại</button>
                            <button @click="upPosts" class="btn-create">Tạo</button>


                        </div>
                    </template>
                </a-modal>
            </div>
        </div>
    </form>
</template>
<!-- this.$refs.ceBlock.getAllContent(); -->


<script>
import CeBlock from './CeBlock.vue';
import { reactive, toRefs, ref } from 'vue';
import { getUser } from '../../services/auth';
import { notification } from 'ant-design-vue';

export default {
    components: {
        CeBlock,
    },

    setup() {
        const ceBlockRef = ref(null);
        const handleInput = (event) => {
            post.title = event.target.innerText.trim(); // Cập nhật giá trị title
        };
        const post = reactive({
            title: '',
            content: '',
            description: '',
            image: '',
            status: 'published',
            users_id: getUser().id
        });


        const upPosts = () => {

            // Lấy dữ liệu từ CeBlock
            const contentData = ceBlockRef.value.getAllContent();

            if (!contentData || contentData.length === 0) {
                notification.error({
                    message: 'Nội dung không được để trống',
                    duration: 2,
                });
                return;
            }

            const imageItem = contentData.find(item => typeof item === 'object' && item.src);
            post.image = imageItem ? imageItem.src : '';
            post.content = JSON.stringify(contentData);

            // Gửi API
            axios.post('http://127.0.0.1:8000/api/posts', post)
                .then((response) => {
                    console.log('Response:', response.data);
                    notification.success({
                        message: 'Bài viết đã được tạo thành công!',
                        duration: 2,
                        style: { backgroundColor: '#f6ffed' },
                    });
                })
                .catch((error) => {
                    const errors = error.response.data.errors;
                    const errorMessage = errors.title?.[0] || errors.content?.[0] || 'Đã xảy ra lỗi';
                    notification.error({
                        message: errorMessage,
                        duration: 2,
                        style: { backgroundColor: '#ffc7c4' },
                    });
                });
        };

        return {
            ceBlockRef,
            upPosts,
            handleInput,
            ...toRefs(post),
        };
    },

    methods: {

        showModal() {
            this.open = true;
        },

    },

    data() {
        return {
            open: false,
        };
    },
};
</script>

<style scoped>
.post-form {
    padding: 25px 30px;
    max-width: 45rem;
    margin: 0 auto;
}

.post-form .title {
    min-height: 2rem;
    padding: 0.5rem 0;
    font-size: 1.875rem;
    font-weight: 500;
    outline: none;
    margin-bottom: 1rem;
}

.post-form .title[placeholder]:empty::before {
    content: attr(placeholder);
    color: #aaa;
}

.next-step {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: center;
    padding: 1rem 0;
    z-index: 1000;
}

.next-step .button {
    cursor: pointer;
    padding: .5rem 1.5rem;
    color: white;
    background-color: #ff7919;
    border: 0;
    border-radius: .25rem;
}

.next-step .button:hover {
    background-color: #da5600;
}

.modal-footer {
    padding: 1rem 0;
}

.modal-footer button {
    border: 1.5px solid #eaeaef;
    width: 7rem;
    padding: .5rem;
    border-radius: .5rem;
    cursor: pointer;
}

.modal-footer .btn-cancel {
    background-color: white;
}

.modal-footer .btn-cancel:hover {
    background-color: #eaeaef;
}

.modal-footer .btn-create {
    background-color: #ff7919;
    color: white;
}

.modal-footer .btn-create:hover {
    background-color: #da5600;

}
</style>
