<template>
    <div class="bio-info_items">
        <label for="" class="fw-bold" style="font-size: 1rem;">CÔNG VIỆC HIỆN TẠI</label>
        <div v-for="(item, index) in jobs" :key="index" class="p-4 fw-bold shadow mt-3">
            {{ item }}
            <a-button size="small" type="link" @click="editJob(index)">Sửa</a-button>
            <a-button size="small" type="link" @click="deleteJob(index)" style="color: red;">Xóa</a-button>
        </div>
        <a-button type="dashed" class="w-100 fw-bold mt-3 " style="height: 3.5rem; font-size: 1.125rem;"
            @click="openJobModal">
            Thêm công việc
        </a-button>


        <a-modal v-model:open="openJobModalFlag" @ok="handleJobOk" @cancel="handleJobCancel" cancelText="Hủy"
            okText="Thêm">
            <div class="modal-info">
                <label for="role" class="fw-bold" style="font-size: .75rem;">CHỨC VỤ</label>
                <a-input v-model:value="role" size="large" class="mt-2" />
            </div>
            <div class="modal-info mt-3">
                <label for="name" class="fw-bold" style="font-size: .75rem;">CÔNG TY</label>
                <a-input v-model:value="company" size="large" class="mt-2" />
            </div>
            <div class="d-flex justify-content-end align-items-center mt-lg-3">
                <label for="role" class="fw-bold me-3" style=" margin-top: 1rem;">HIỆN ĐANG LÀM</label>
                <a-switch v-model:checked="checked" size="default" class="mt-3" />

            </div>
        </a-modal>
    </div>
</template>


<script>

export default {
    name: 'JobInfo',
    data() {
        return {
            checked: false,
            openJobModalFlag: false,
            role: "",
            company: "",
            jobs: [],
            editingJobIndex: null,
        };
    },
    methods: {

        openJobModal() {
            if (this.editingJobIndex === null) {
                this.role = "";
                this.company = "";
                this.checked = false;
            }
            this.openJobModalFlag = true;
        },
        editJob(index) {
            this.editingJobIndex = index;
            const job = this.jobs[index];
            const [role, company] = job.split(' tại ');
            this.role = role.replace('Hiện đang làm ', '');
            this.company = company;
            this.checked = job.startsWith('Hiện đang làm');
            this.openJobModalFlag = true;
        },
        handleJobOk() {
            let jobText = "";
            if (this.checked) {
                jobText = `Hiện đang làm ${this.role} tại ${this.company}`;
            } else {
                jobText = `${this.role} tại ${this.company}`;
            }

            if (this.editingJobIndex !== null) {
                this.jobs[this.editingJobIndex] = jobText;
            } else {
                this.jobs.push(jobText);
            }

            this.openJobModalFlag = false;
            this.editingJobIndex = null;
        },
        handleJobCancel() {
            this.openJobModalFlag = false;
            this.editingJobIndex = null;
        },
        deleteJob(index) {
            this.jobs.splice(index, 1);
        },
    },
};
</script>
