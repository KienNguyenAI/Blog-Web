<template>
    <div class="bio-info_items">
        <div class="bio-info_items mt-5">
            <label for="" class="fw-bold" style="font-size: 1rem;">HỌC VẤN</label>
            <div v-for="(item, index) in education" :key="index" class="p-4 fw-bold shadow mt-3">
                {{ item }}
                <a-button size="small" type="link" @click="edit(index)">Sửa</a-button>
                <a-button size="small" type="link" @click="deleteEdu(index)" style="color: red;">Xóa</a-button>
            </div>
            <a-button type="dashed" class="w-100 fw-bold mt-3" style="height: 3.5rem; font-size: 1.125rem;"
                @click="open">
                Thêm trường học
            </a-button>
            <a-modal v-model:open="isModalOpen" @ok="handleOk" @cancel="handleCancel" cancelText="Hủy" okText="Thêm">
                <div class="modal-info mt-3">
                    <label for="school" class="fw-bold" style="font-size: .75rem;">TRƯỜNG HỌC</label>
                    <a-input v-model:value="school" size="large" class="mt-2" />
                </div>
                <div class="d-flex justify-content-end align-items-center mt-lg-3">
                    <label for="current" class="fw-bold me-3" style="margin-top: 1rem;">HIỆN ĐANG HỌC</label>
                    <a-switch v-model:checked="isStudying" size="default" class="mt-3" />
                </div>
            </a-modal>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SchInfo',
    data() {
        return {
            degree: "",
            school: "",
            isStudying: false,
            education: [],
            isModalOpen: false,
            editIndex: null,
        };
    },
    methods: {
        open() {
            if (this.editIndex === null) {
                this.degree = "";
                this.school = "";
                this.isStudying = false;
            }
            this.isModalOpen = true;
        },

        edit(index) {
            this.editIndex = index;
            const educationItem = this.education[index];


            const parts = educationItem.split(' tại ');


            this.degree = parts[0];
            this.school = parts[1];
            this.isStudying = educationItem.includes('Hiện đang học');

            this.isModalOpen = true;
        },


        handleOk() {
            let educationText = "";
            if (this.isStudying) {
                educationText = `Hiện đang học tại ${this.school}`;
            } else {
                educationText = `Đã học tại ${this.school}`;
            }

            if (this.editIndex !== null) {
                this.education[this.editIndex] = educationText;
            } else {
                this.education.push(educationText);
            }

            this.isModalOpen = false;
            this.editIndex = null;
        },

        handleCancel() {
            this.isModalOpen = false;
            this.editIndex = null;
        },

        deleteEdu(index) {
            this.education.splice(index, 1);
        },
    },
};
</script>
