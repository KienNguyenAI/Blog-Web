<template>
    <div class="ce-block-container">
        <div v-for="(block, index) in blocks" :key="index" class="ce-block">
            <div class="ce-block__content">
                <template v-if="block.type === 'text'">
                    <div class="ce-paragraph cdx-block" contenteditable="true" @keydown="handleKeydown($event, index)"
                        @mouseup="showToolbar" @keyup="showToolbar" @focus="setActiveBlock(index)"
                        @input="updateBlockContent($event, index)" :placeholder="index === 0 ? 'Nội dung bài viết' : ''"
                        ref="paragraphs"></div>

                    <div class="add-block-buttons" v-if="activeBlockIndex === index && !blocks[index].content.trim()">
                        <a-dropdown placement="bottom" arrow>
                            <i class="fa-solid fa-plus ant-dropdown-link" @click="addBlock('image', index)"></i>
                            <template #overlay>
                                <a-menu class="d-flex flex-column align-items-center p-2">
                                    <span>Thêm hình ảnh</span>
                                </a-menu>
                            </template>
                        </a-dropdown>
                    </div>

                </template>
                <template v-if="block.type === 'image'">
                    <div class="ce-image-block">
                        <div class="img-tool " v-if="blocks[index].isImageUploaded">
                            <a-dropdown :trigger="['click']">
                                <div class="img-tool_img ant-dropdown-link">
                                    <img :src="blocks[index].content" alt="Uploaded Image" class="mb-1">
                                </div>
                                <template #overlay>
                                    <a-menu>
                                        <a-menu class="d-flex flex-column align-items-center p-2">
                                            <span> <i class="fa-solid fa-x close" @click="deleteImage(index)"></i>
                                            </span>

                                        </a-menu>
                                    </a-menu>
                                    < </template>
                            </a-dropdown>

                            <div class="caption cdx-block mt-1" contenteditable="true" :placeholder="'caption'"
                                v-if="blocks[index].isImageUploaded">

                            </div>
                        </div>
                        <a-spin size="large" class="mb-3" v-if="!blocks[index].isImageUploaded" />

                        <div class="btn-upload d-flex flex-column" v-if="!blocks[index].isImageUploaded"
                            @click="triggerFileInput(index)">
                            <i class="fa-solid fa-image mb-3"></i>
                            Chọn hình ảnh
                            <input type="file" accept="image/*" class="file-input"
                                @change="handleImageUpload($event, index)" />
                        </div>
                        <i class="fa-solid fa-x close" v-if="!blocks[index].isImageUploaded"
                            @click="removeImage(index)"></i>
                    </div>


                </template>
            </div>
        </div>
        <div v-if="showingToolbar" :style="toolbarStyle" class="toolbar">
            <div v-for="button in toolbarButtons" :key="button.label || button.type" class="toolbar-button">
                <template v-if="button.type === 'separator'">
                    <div class="toolbar-separator"></div>
                </template>
                <template v-else>
                    <a-dropdown :placement="'bottom'" arrow>
                        <button :class="{ active: activeStates[button.state] }" type="button" v-html="button.label"
                            @click="applyAction(button.action)">
                        </button>
                        <template #overlay>
                            <a-menu class="d-flex flex-column align-items-center p-2">
                                <span>{{ button.tooltip }}</span>
                                <span class="fw-bold text-secondary" style="font-size: .7rem;">
                                    {{ button.shortcut }}
                                </span>
                            </a-menu>
                        </template>
                    </a-dropdown>
                </template>

            </div>
            <div v-if="showLinkInput" class="link-input">
                <input type="text" v-model="linkURL" placeholder="Nhập liên kết (URL)" class="form-control" />
                <div class="link-buttons">
                    <button @click="applyLink">Chèn</button>
                    <button @click="cancelLink">Hủy</button>
                </div>
            </div>

        </div>


    </div>
</template>


<script>
export default {
    data() {
        return {
            blocks: [{ type: 'text', content: '', isImageUploaded: false }],
            activeBlockIndex: null,
            activeBlockIndex: null,
            showingToolbar: false,
            showLinkInput: false,
            linkURL: '',
            toolbarStyle: {},

            activeStates: {
                bold: false,
                italic: false,
                underline: false,
                link: false,
                alignLeft: false,
                alignCenter: false,
                alignRight: false,
                alignJustify: false,
                h2: false,
                h3: false,
                quote: false,
            },
            toolbarButtons: [

                { label: 'H3', action: 'applyH3', state: 'h3', shortcut: '', tooltip: 'Đề mục nhỏ' },
                { label: 'H2', action: 'applyH2', state: 'h2', shortcut: '', tooltip: 'Đề mục lớn' },
                { label: '<i class="fa-solid fa-angles-right"></i>', action: 'applyQuote', state: 'quote', shortcut: '', tooltip: 'Trích dẫn dài' },
                { type: 'separator' },
                { label: 'B', action: 'applyBold', state: 'bold', shortcut: 'Ctrl+B', tooltip: 'Bold' },
                { label: 'I', action: 'applyItalic', state: 'italic', shortcut: 'Ctrl+I', tooltip: 'Italic' },
                { label: 'U', action: 'applyUnderline', state: 'underline', shortcut: 'Ctrl+U', tooltip: 'Underline' },
                // { label: '<i class="fa-solid fa-link"></i>', action: 'toggleLinkInput', state: 'link', tooltip: 'Thêm link' },
                { type: 'separator' },
                { label: '<i class="fa-solid fa-align-left"></i>', action: 'alignLeft', state: 'alignLeft', tooltip: 'Align Left' },
                { label: '<i class="fa-solid fa-align-center"></i>', action: 'alignCenter', state: 'alignCenter', tooltip: 'Align Center' },
                { label: '<i class="fa-solid fa-align-right"></i>', action: 'alignRight', state: 'alignRight', tooltip: 'Align Right' },
                { label: '<i class="fa-solid fa-align-justify"></i>', action: 'alignJustify', state: 'alignJustify', tooltip: 'Justify' }
            ],
            showLinkInput: false,
            linkURL: '',
        };
    },
    methods: {
        getAllContent() {
            const contents = Array.from(this.$el.querySelectorAll('.ce-block__content'));

            return contents.map((content, index) => {
                const clone = content.cloneNode(true);

                const buttons = clone.querySelector('.add-block-buttons');
                if (buttons) {
                    buttons.remove();
                }
                const editableElements = clone.querySelectorAll('[contenteditable]');
                editableElements.forEach(element => {
                    element.removeAttribute('contenteditable');
                });


                const block = this.blocks[index];
                if (block.type === 'image') {
                    const imgSrc = block.content;
                    const captionEl = clone.querySelector('.caption');
                    const caption = captionEl ? captionEl.innerText.trim() : '';
                    return {
                        src: imgSrc,
                        caption: caption,
                    };
                }
                return clone.innerHTML.trim();
            });
        },

        setActiveBlock(index) {
            this.activeBlockIndex = index;
        },
        addBlock(type) {
            if (type === 'text' && this.activeBlockIndex !== null) {
                this.blocks.splice(this.activeBlockIndex + 1, 0, { type: 'text', content: '' });
            }
        },
        updateButtonPositions() {
            if (this.activeBlockIndex !== null) {
                this.$forceUpdate();
            }
        },
        addBlock(type, index) {
            if (type === 'image') {
                this.blocks.splice(index, 0, { type: 'image', content: '' });
            }
        },
        triggerFileInput(index) {

            const block = this.$el.querySelectorAll('.ce-block')[index];
            if (block) {
                const fileInput = block.querySelector('.file-input');
                if (fileInput) {
                    fileInput.click();
                }
            }
        },
        async handleImageUpload(event, index) {
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('image', file);

                try {
                    // Gửi file tới Laravel API
                    const response = await axios.post('http://127.0.0.1:8000/api/upload', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    });

                    // Cập nhật content của block với đường dẫn ảnh trả về
                    this.blocks[index].content = response.data.filePath;
                    this.blocks[index].isImageUploaded = true;
                } catch (error) {
                    console.error('Upload failed:', error);
                }
            }
        },
        removeImage(index) {
            this.blocks[index].isImageUploaded = false;
            this.blocks.splice(index, 1);
        },
        deleteImage(index) {
            this.blocks[index].isImageUploaded = false;

            const imagePath = this.blocks[index].content;

            if (!imagePath) {
                console.error('No image path found for deletion');
                return;
            }


            axios.post('http://127.0.0.1:8000/api/delete-image', { filePath: imagePath })
                .then(response => {
                    console.log(response.data.message);

                    this.blocks.splice(index, 1);
                })
                .catch(error => {
                    console.error('Failed to delete image:', error);
                });
        },
        // link



        handleKeydown(event, index) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();

                this.blocks.splice(index + 1, 0, { type: 'text', content: '' });
                this.$nextTick(() => {

                    const newBlock = document.querySelectorAll('.ce-paragraph')[index + 1];
                    if (newBlock) newBlock.focus();
                });

            } else if (event.key === 'Backspace') {
                const blockContent = event.target.innerText.trim();
                if (blockContent === '' && this.blocks.length > 1) {
                    event.preventDefault();
                    this.blocks.splice(index, 1);
                    this.$nextTick(() => {
                        const previousBlock = document.querySelectorAll('.ce-paragraph')[index - 1];
                        if (previousBlock) {
                            const range = document.createRange();
                            const selection = window.getSelection();
                            range.selectNodeContents(previousBlock);
                            range.collapse(false);
                            selection.removeAllRanges();
                            selection.addRange(range);
                            previousBlock.focus();
                        }
                    });
                }
            }
            this.$nextTick(this.updateButtonPositions);
        },
        showToolbar() {
            setTimeout(() => {
                const selection = window.getSelection();
                if (selection && selection.toString().trim() !== '' && selection.rangeCount > 0) {
                    const range = selection.getRangeAt(0);
                    const rect = range.getBoundingClientRect();
                    this.toolbarStyle = {
                        top: `${rect.bottom - 160 + window.scrollY}px`,
                        left: `${rect.left - 525 + window.scrollX}px`,
                    };
                    this.updateActiveStates();
                    this.showingToolbar = true;
                } else {
                    this.showingToolbar = false;
                }
            }, 0);
        },

        applyAction(action) {

            switch (action) {
                case 'applyBold':
                    document.execCommand('bold');
                    break;
                case 'applyItalic':
                    document.execCommand('italic');
                    break;
                case 'applyUnderline':
                    document.execCommand('underline');
                    break;
                case 'applyLink':
                    this.showLinkInput = true;
                    this.$nextTick(() => {
                        const input = document.querySelector('.toolbar-input input');
                        if (input) input.focus();
                    });
                    break;
                case 'alignLeft':
                    document.execCommand('justifyLeft');
                    break;
                case 'alignCenter':
                    document.execCommand('justifyCenter');
                    break;
                case 'alignRight':
                    document.execCommand('justifyRight');
                    break;
                case 'alignJustify':
                    document.execCommand('justifyFull');
                    break;
                case 'applyH2':
                    if (this.activeStates.h2) {
                        document.execCommand('formatBlock', false, 'p');
                    } else {
                        document.execCommand('formatBlock', false, 'h2');
                    }
                    this.updateActiveStates();
                    break;
                case 'applyH3':
                    if (this.activeStates.h3) {
                        document.execCommand('formatBlock', false, 'p');
                    } else {
                        document.execCommand('formatBlock', false, 'h3');
                    }
                    this.updateActiveStates();
                    break;
                case 'applyQuote':
                    this.toggleQuote();
                    break;
                default:
                    break;
            }
            this.updateActiveStates();
        },
        toggleQuote() {
            const selection = window.getSelection();
            if (selection && selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                let selectedNode = range.startContainer;

                const blockElement = selectedNode.nodeType === 3
                    ? selectedNode.parentNode.closest('.ce-quote, .ce-paragraph')
                    : selectedNode.closest('.ce-quote, .ce-paragraph');

                if (blockElement) {
                    if (blockElement.classList.contains('ce-quote')) {
                        blockElement.classList.remove('ce-quote');
                        blockElement.classList.add('ce-paragraph');
                        this.activeStates.quote = false;
                    } else if (blockElement.classList.contains('ce-paragraph')) {
                        blockElement.classList.remove('ce-paragraph');
                        blockElement.classList.add('ce-quote');
                        this.activeStates.quote = true;
                    }
                    // Loại bỏ H2 và H3 khi bật/tắt Quote
                    this.activeStates.h2 = false;
                    this.activeStates.h3 = false;
                }
            }
        },
        updateActiveStates() {

            this.activeStates.bold = document.queryCommandState('bold');
            this.activeStates.italic = document.queryCommandState('italic');
            this.activeStates.underline = document.queryCommandState('underline');
            this.activeStates.link = document.queryCommandState('createLink');
            this.activeStates.alignLeft = document.queryCommandState('justifyLeft');
            this.activeStates.alignCenter = document.queryCommandState('justifyCenter');
            this.activeStates.alignRight = document.queryCommandState('justifyRight');
            this.activeStates.alignJustify = document.queryCommandState('justifyFull');

            const selection = window.getSelection();
            if (selection && selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                let selectedNode = range.startContainer;

                // Nếu là text node, lấy parent node
                if (selectedNode.nodeType === 3) {
                    selectedNode = selectedNode.parentNode;
                }

                // Tìm thẻ chứa định dạng
                const blockElement = selectedNode.closest('h2, h3, .ce-quote, .ce-paragraph');
                if (blockElement) {
                    this.activeStates.quote = blockElement.classList.contains('ce-quote');
                    this.activeStates.h2 = blockElement.tagName.toLowerCase() === 'h2';
                    this.activeStates.h3 = blockElement.tagName.toLowerCase() === 'h3';
                } else {
                    this.activeStates.quote = false;
                    this.activeStates.h2 = false;
                    this.activeStates.h3 = false;
                }
            } else {
                this.activeStates.quote = false;
                this.activeStates.h2 = false;
                this.activeStates.h3 = false;
            }
        },

        updateBlockContent(event, index) {
            this.blocks[index].content = event.target.innerText;
        },

    },
    mounted() {
        document.addEventListener('selectionchange', this.showToolbar);


    },
    beforeDestroy() {
        document.removeEventListener('selectionchange', this.showToolbar);
    },
};
</script>


<style scoped>
.ce-block-container {
    position: relative;
    font-family: "Noto Serif", Regular, Times New Roman;
}

.ce-paragraph {
    outline: none;
    padding: 0.475rem 0;
    font-size: 1.4rem;
    margin-bottom: 1.25rem;
    font-weight: 400;
}

.ce-quote {
    font-style: italic;
    outline: none;
    padding: 0.625rem 0.75rem 0.625rem 2rem;
    margin-bottom: 1.25rem;
    font-size: 1.1875rem;
    border-left: 2.5px solid #ff7919;
}

.ce-quote:hover {
    background-color: #fff8f4;

}

.cdx-block[placeholder]:empty::before {
    content: attr(placeholder);
    color: #aaa;
}

.toolbar {
    position: absolute;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    z-index: 10;
    display: flex;
    gap: 5px;
}

.toolbar .h2 {
    font-weight: 500;
}

.toolbar .h3 {
    font-weight: 400;
}

.toolbar button {
    background: none;
    border: none;
    cursor: pointer;
    font-weight: bold;
    padding: 5px;
}

.toolbar button:hover {
    background-color: #eaeaef;
}

.toolbar button.active {
    color: #ff7919 !important;

    border-radius: 3px;
}

.toolbar-input {
    display: flex;
    align-items: center;
    width: 100%;
}

.toolbar-input input {
    width: 150px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 14px;
}

.toolbar-input input:focus {
    outline: none;
    border-color: #ff7919;
}

.toolbar-separator {
    width: 1px;
    height: 25px;
    background-color: #ccc;
    margin: 0 5px;
    display: inline-block;
    vertical-align: middle;
}

.ce-toolbar {
    position: absolute;
    top: 50%;
    left: -30px;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 1.875rem;
    height: 1.875rem;
    cursor: pointer;
}

.add-block-buttons {
    position: absolute;
    cursor: pointer;
    transform: translate(-110%, -180%);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
}

.add-block-buttons:hover {
    color: #ff7919;
}

.ce-image-block {
    margin-bottom: 1.25rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin: 1rem 0;
}

.ce-image-block .close,
.ce-image-block .btn-upload {
    cursor: pointer;
    padding: 1rem;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: .5rem;

}

.ce-image-block .close:hover,
.ce-image-block .btn-upload:hover {
    background-color: #fafafa;
}

.file-input {
    display: none;
    /* Ẩn input file */
}

.img-tool_img img {
    width: 100%;
}

.ce-image-block .caption {
    padding: 0.625rem 0.75rem;
    outline: none;
    font-size: 1.1rem;
}
</style>
