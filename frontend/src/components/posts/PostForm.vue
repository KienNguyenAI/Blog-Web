<template>
    <form action="" @submit.prevent="upPosts()">
        <div class="post-form">
            <div class="title" contenteditable="true" @input="handleInput" v-html="title"
                placeholder="Tiêu đề bài viết.....">
            </div>


            <div class="editor">
                <div class="codex-editor " style="padding-bottom: 20rem;">


                    <CeBlock ref="ceBlockRef" :parsedContent="parsedContent" />

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
                        <div class="post-category mt-3 ">
                            <label for="" class="fw-bold" style="font-size: .7rem;">Chọn danh mục</label>
                            <div class="post_category_list mt-3">
                                <div class="selected-topic d-flex flex-wrap">
                                    <div class="topic selected-tag" v-for="(tag, index) in selectedTags"
                                        :key="'selected-' + index">
                                        {{ tag.name }}
                                        <span @click="removeSelectedTag(index)"
                                            style="cursor: pointer; margin-left: 0.5rem;">&times;</span>
                                    </div>
                                </div>
                                <div class="category_list shadow p-3 mt-3">
                                    <div class="topic" v-for="(tag, index) in tagsData" :key="'available-' + index"
                                        @click="toggleSelectTag(index)">
                                        {{ tag.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template #footer>
                        <div class=" d-flex justify-content-center align-items-center modal-footer">
                            <button type="button" @click="open = false" class="btn-cancel me-3">Quay
                                lại</button>
                            <button @click="upPosts()" v-if="!id" class="btn-create">Tạo</button>
                            <button @click="upPosts(id)" v-else class="btn-create">Cập nhật</button>
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
import { reactive, toRefs, ref, watch, onMounted } from 'vue';
import { getUser } from '../../services/auth';
import { notification } from 'ant-design-vue';
import { useRouter } from 'vue-router';
import TopicName from '../TopicName.vue';
export default {
    components: {
        CeBlock,
        TopicName
    },
    props: {
        id: Number,
        title: String,
        content: String,
    },
    setup(props) {
        const post = reactive({
            title: props.title || '',
            content: '',
            description: '',
            image: '',
            status: 'archived',
            users_id: getUser().id,
            tags_id: '',
        });

        const parsedContent = ref(null);

        const parseContent = () => {
            try {
                const contentArray = JSON.parse(props.content);

                parsedContent.value = contentArray.map(item => {
                    if (typeof item === 'string') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(item, 'text/html');
                        return { type: 'html', content: doc.body.innerText.trim() }; // Lưu dưới dạng văn bản
                    }

                    else if (typeof item === 'object' && item.src) {
                        return { type: 'image', src: item.src, caption: item.caption || '' }; // Lưu thông tin hình ảnh
                    }

                    return null;
                }).filter(item => item !== null);
            } catch (error) {
                console.error("Lỗi khi parse nội dung bài viết:", error);
            }
        };






        onMounted(() => {
            parseContent();
        });

        const router = useRouter();
        const ceBlockRef = ref(null);

        const tagsData = ref([]);
        const selectedTags = ref([]);

        const fetchTags = async () => {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/tags');
                tagsData.value = response.data.map(tag => ({ id: tag.id, name: tag.name })); // Lưu cả id và name
            } catch (error) {
                console.error('Không thể lấy danh sách tags:', error);
            }
        };

        const toggleSelectTag = (index) => {
            const selectedTag = tagsData.value[index];

            if (selectedTags.value.length > 0) {
                const removedTag = selectedTags.value.pop();
                tagsData.value.push(removedTag);
            }

            selectedTags.value.push(selectedTag);
            tagsData.value.splice(index, 1);
        };


        const removeSelectedTag = (index) => {
            const removedTag = selectedTags.value[index];
            tagsData.value.push(removedTag);
            selectedTags.value.splice(index, 1);
        };


        fetchTags();

        const handleInput = (event) => {
            post.title = event.target.innerText.trim();
        };



        const upPosts = (id) => {

            const contentData = ceBlockRef.value.getAllContent();
            if (!contentData || contentData.length === 0) {
                notification.error({
                    message: 'Nội dung không được để trống',
                    duration: 2,
                });
                return;
            }

            if (!post.description) {
                const contentText = contentData.map(item => {

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(item, 'text/html');
                    return doc.body.innerText.trim();
                }).join('. ');

                const words = contentText.split(' ');
                if (words.length > 30) {
                    post.description = words.slice(0, 50).join(' ') + '...';
                } else {
                    post.description = contentText;
                }
            }
            const imageItem = contentData.find(item => typeof item === 'object' && item.src);
            post.image = imageItem ? imageItem.src : '';
            post.content = JSON.stringify(contentData);


            const tags_id = selectedTags.value.map(tag => tag.id);

            if (tags_id === 0) {
                notification.error({
                    message: 'Bạn cần chọn ít nhất một danh mục',
                    duration: 2,
                    style: { backgroundColor: '#ffc7c4' },
                });
                return;
            }
            post.tags_id = tags_id[0];
            const requestMethod = id ? axios.put : axios.post;
            const requestUrl = id ? `http://127.0.0.1:8000/api/posts/${id}` : 'http://127.0.0.1:8000/api/posts';

            // Gửi API
            requestMethod(requestUrl, post)
                .then((response) => {
                    const postData = response.data;
                    post.value = postData.post;
                    router.push(`/post/${post.value.slug}`);
                    notification.success({
                        message: id ? 'Bài viết đã được cập nhật thành công!' : 'Bài viết đã được tạo thành công!',
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
            tagsData,
            selectedTags,
            removeSelectedTag,
            toggleSelectTag,
            parsedContent
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
    /* */
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

.post_category_list .category_list {
    display: flex;
    flex-wrap: wrap;
    max-height: 15rem;
    overflow-y: auto;
    padding-right: 0.5rem;
    border-radius: .5rem;
}


.post_category_list .topic {
    border: 1px solid #c4c4c4;
    border-radius: 3rem;
    padding: .2rem 1rem;
    margin-bottom: .5rem;
    margin-right: .375rem;
    cursor: pointer;
}

.post_category_list .topic:hover {
    background-color: #eaeaef;
}
</style>
