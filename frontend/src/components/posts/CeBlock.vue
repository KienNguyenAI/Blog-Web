<template>
    <div class="ce-block-container">
        <div v-for="(block, index) in blocks" :key="index" class="ce-block">
            <div class="ce-block__content">
                <div class="ce-paragraph cdx-block" contenteditable="true" @keydown="handleKeydown($event, index)"
                    @mouseup="showToolbar" @keyup="showToolbar" :placeholder="index === 0 ? 'Nội dung bài viết' : ''">
                </div>
            </div>
        </div>
        <div v-if="showingToolbar" :style="toolbarStyle" class="toolbar">
            <div v-for="button in toolbarButtons" :key="button.label" class="toolbar-button">
                <a-dropdown :placement="'bottom'" arrow>
                    <button :class="{ active: activeStates[button.state] }" @click="applyAction(button.action)"
                        v-html="button.label">
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            blocks: [{}],
            showingToolbar: false,
            toolbarStyle: {},
            activeStates: {
                bold: false,
                italic: false,
                underline: false,
                link: false,
                alignLeft: false,
                alignCenter: false,
                alignRight: false,
                alignJustify: false
            },

            toolbarButtons: [
                {
                    label: 'B',
                    action: 'applyBold',
                    state: 'bold',
                    shortcut: 'Ctr+B',
                    tooltip: 'Bold'
                },
                {
                    label: 'I',
                    action: 'applyItalic',
                    state: 'italic',
                    shortcut: 'Ctr+I',
                    tooltip: 'Italic'
                },
                {
                    label: 'U',
                    action: 'applyUnderline',
                    state: 'underline',
                    shortcut: 'Ctr+U',
                    tooltip: 'Underline'
                },
                {
                    label: '🔗',
                    action: 'applyLink',
                    state: 'link',
                    shortcut: '',
                    tooltip: 'Link'
                },
                {
                    label: '<i class="fa-solid fa-align-left"></i>',
                    action: 'alignLeft',
                    state: 'alignLeft',
                    shortcut: '',
                    tooltip: 'Align Left'
                },
                {
                    label: '<i class="fa-solid fa-align-center"></i>',
                    action: 'alignCenter',
                    state: 'alignCenter',
                    shortcut: '',
                    tooltip: 'Align Center'
                },
                {
                    label: '<i class="fa-solid fa-align-right"></i>',
                    action: 'alignRight',
                    state: 'alignRight',
                    shortcut: '',
                    tooltip: 'Align Right'
                },
                {
                    label: '<i class="fa-solid fa-align-justify"></i>',
                    action: 'alignJustify',
                    state: 'alignJustify',
                    shortcut: '',
                    tooltip: 'Justify'
                }
            ],

        };
    },
    methods: {
        handleKeydown(event, index) {
            if (event.key === 'Enter' && !event.shiftKey) {

                event.preventDefault();
                this.blocks.splice(index + 1, 0, {});
                this.$nextTick(() => {
                    const newBlock = document.querySelectorAll('.ce-paragraph')[index + 1];
                    if (newBlock) newBlock.focus();
                });
            } if (event.key === 'Enter' && event.shiftKey) {
                event.preventDefault();
                const selection = window.getSelection();
                const range = selection.getRangeAt(0);

                // Tạo thẻ <br> và thêm nó vào nội dung
                const lineBreak = document.createElement('br');
                range.insertNode(lineBreak);

                // Đặt con trỏ sau thẻ <br>
                range.setStartAfter(lineBreak);
                range.setEndAfter(lineBreak);
                selection.removeAllRanges();
                selection.addRange(range);


            }
            if (event.key === 'Backspace') {
                const blockContent = event.target.innerText.trim();
                if (blockContent === '' && this.blocks.length > 1) {
                    event.preventDefault();
                    this.blocks.splice(index, 1);
                    this.$nextTick(() => {
                        const previousBlock = document.querySelectorAll('.ce-paragraph')[index - 1];
                        if (previousBlock) previousBlock.focus();
                    });
                }
            }
        }

        ,
        showToolbar() {
            setTimeout(() => {
                const selection = window.getSelection();
                if (selection && selection.toString().trim() !== '' && selection.rangeCount > 0) {
                    const range = selection.getRangeAt(0);
                    const rect = range.getBoundingClientRect();

                    // Tính vị trí và hiển thị toolbar
                    this.toolbarStyle = {
                        top: `${rect.bottom - 160 + window.scrollY}px`,
                        left: `${rect.left - 525 + window.scrollX}px`,
                    };
                    // Cập nhật trạng thái các nút
                    this.activeStates.bold = document.queryCommandState('bold');
                    this.activeStates.italic = document.queryCommandState('italic');
                    this.activeStates.underline = document.queryCommandState('underline');
                    this.activeStates.link = document.queryCommandState('createLink'); // Kiểm tra xem có link không
                    this.activeStates.alignLeft = document.queryCommandState('justifyLeft');
                    this.activeStates.alignCenter = document.queryCommandState('justifyCenter');
                    this.activeStates.alignRight = document.queryCommandState('justifyRight');
                    this.activeStates.alignJustify = document.queryCommandState('justifyFull');


                    this.showingToolbar = true;
                } else {
                    this.showingToolbar = false; // Ẩn toolbar nếu không có vùng chọn
                }
            }, 0);
        },
        applyAction(action) {
            if (action === 'applyBold') {
                document.execCommand('bold');
            } else if (action === 'applyItalic') {
                document.execCommand('italic');
            } else if (action === 'applyUnderline') {
                document.execCommand('underline');
            } else if (action === 'applyLink') {
                this.applyLink();
            } else if (action === 'alignLeft') {
                document.execCommand('justifyLeft');
            } else if (action === 'alignCenter') {
                document.execCommand('justifyCenter');
            } else if (action === 'alignRight') {
                document.execCommand('justifyRight');
            } else if (action === 'alignJustify') {
                document.execCommand('justifyFull');
            }
            // Cập nhật lại trạng thái các nút
            this.updateActiveStates();
        },

        applyLink() {
            if (url) {
                document.execCommand('createLink', false, url);
                document.execCommand('bold');
                document.execCommand('underline');
            }
        },
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
}

.ce-paragraph {
    outline: none;
    padding: 0.475rem 0;
    font-size: 1.2rem;
    margin-bottom: 1.25rem;
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
    color: #ff7919;
    border-radius: 3px;
}
</style>
