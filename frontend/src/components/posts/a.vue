<template>
    <!-- <template v-if="block.type === 'text'">
                    <div :class="block.class || 'ce-paragraph cdx-block'" contenteditable="true"
                        @keydown="handleKeydown($event, index)" @mouseup="showToolbar" @keyup="showToolbar"
                        :placeholder="index === 0 ? 'Nội dung bài viết' : ''">
                    </div>
                </template> -->
    <!-- <template v-else-if="block.type === 'quote'">
                    <blockquote contenteditable="true" class="ce-quote" @input="updateBlockContent($event, index)">
                        <i>{{ block.content || 'Thêm trích dẫn...' }}</i>
                    </blockquote>
                </template> -->
    <!-- <div class="add-block-buttons">
            <button @click="addBlock('quote')">Thêm Trích dẫn</button>
            <button @click="addBlock('image')">Thêm Hình ảnh</button>
        </div> -->
    addBlock(type) {
    if (type === 'quote') {
    this.blocks.push({ type: 'text', class: 'ce-quote', content: '' });
    // this.blocks.push({ type: 'quote', content: '' });
    } else if (type === 'image') {
    this.blocks.push({ type: 'image', src: '' });
    }
    },
</template>