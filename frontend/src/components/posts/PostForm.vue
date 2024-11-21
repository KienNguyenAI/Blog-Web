<template>
    <div class="post-form">
        <div class="title" contenteditable="true" @input="handleInput" placeholder="Tiêu đề bài viết.....">
        </div>
        <div class="editor">
            <div class="codex-editor">
                <CeBlock />
            </div>
        </div>
        <div class="next-step">
            <!-- Nút mở modal -->
            <button class="button" @click="showModal">Bước tiếp theo</button>

            <!-- Modal -->
            <a-modal v-model:open="open" @ok="handleOk" ok-text="Tạo" cancel-text="Quay lại">
                <div>
                    <label for="" class="fw-bold">Mô tả bài viết </label>
                </div>
            </a-modal>
        </div>
    </div>
</template>



<script>
import CeBlock from './CeBlock.vue';

export default {
    components: {
        CeBlock,
    },
    data() {
        return {
            open: false,
        };
    },
    methods: {
        showModal() {
            this.open = true;
        },
        handleOk() {
            this.open = false;
        },
    },

}
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
</style>
