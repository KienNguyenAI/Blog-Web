<template>
    <div class="bio-info_items mt-5">
        <label for="" class="fw-bold" style="font-size: 1rem;">QUÊ QUÁN</label>
        <div v-for="(item, index) in hometowns" :key="index" class="p-4 fw-bold shadow mt-3">
            {{ item }}
            <a-button size="small" type="link" @click="editHometown(index)">Sửa</a-button>
            <a-button size="small" type="link" @click="deleteHometown(index)" style="color: red;">Xóa</a-button>
        </div>
        <a-button type="dashed" class="w-100 fw-bold mt-3" style="height: 3.5rem; font-size: 1.125rem;"
            @click="openHometownModal">
            Thêm quê quán
        </a-button>

        <!-- Modal -->
        <a-modal v-model:open="openHometownModalFlag" @ok="handleHometownOk" @cancel="handleHometownCancel"
            cancelText="Hủy" okText="Thêm">
            <div class="modal-info">
                <label for="hometown" class="fw-bold" style="font-size: .75rem;">QUÊ QUÁN</label>
                <a-input v-model:value="hometown" size="large" class="mt-2" />
            </div>
        </a-modal>
    </div>
</template>

<script>
export default {
    name: 'HomeTownInfo',
    data() {
        return {
            hometown: "",
            hometowns: [],
            openHometownModalFlag: false,
            editingHometownIndex: null,
        };
    },
    methods: {

        openHometownModal() {
            if (this.editingHometownIndex === null) {
                this.hometown = "";
            }
            this.openHometownModalFlag = true;
        },


        editHometown(index) {
            this.editingHometownIndex = index;
            this.hometown = this.hometowns[index];
            this.openHometownModalFlag = true;
        },


        handleHometownOk() {
            if (this.editingHometownIndex !== null) {
                this.hometowns[this.editingHometownIndex] = this.hometown;
            } else {
                this.hometowns.push(this.hometown);
            }
            this.openHometownModalFlag = false;
            this.editingHometownIndex = null;
        },

        handleHometownCancel() {
            this.openHometownModalFlag = false;
            this.editingHometownIndex = null;
        },


        deleteHometown(index) {
            this.hometowns.splice(index, 1);
        },
    },
};
</script>