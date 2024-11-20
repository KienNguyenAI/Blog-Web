<template>
    <div class="post-form">
        <div class="title" contenteditable="true" @input="handleInput" placeholder="Tiêu đề bài viết.....">
        </div>
        <div class="editor">
            <div class="codex-editor">
                <CeBlock />
            </div>
        </div>
    </div>
</template>


<script>
import CeBlock from './CeBlock.vue';
export default {
    components: {
        CeBlock,
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

.ce-paragraph {
    outline: none;
    padding: .475rem 0;
    font-size: 1.2rem;
    margin-bottom: 1.25rem;
}

.cdx-block[placeholder]:empty::before {
    content: attr(placeholder);
    color: #aaa;
}
</style>
