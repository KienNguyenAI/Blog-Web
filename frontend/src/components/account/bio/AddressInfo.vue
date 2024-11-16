<template>
    <div class="bio-info_items mt-5">
        <label for="" class="fw-bold" style="font-size: 1rem;">NƠI Ở HIỆN TẠI</label>
        <div v-if="address" class="p-4 fw-bold shadow mt-3">
            {{ address }}
        </div>
        <a-button type="dashed" class="w-100 fw-bold mt-3" style="height: 3.5rem; font-size: 1.125rem;"
            @click="openModal">
            Thêm nơi ở hiện tại
        </a-button>

        <a-modal v-model:open="modalOpen" @ok="saveAddress" @cancel="cancel" cancelText="Hủy" okText="Thêm">
            <div class="modal-info">
                <label for="city" class="fw-bold" style="font-size: .75rem;">TỈNH/THÀNH PHỐ HIỆN TẠI</label>
                <a-input v-model:value="city" size="large" class="mt-2" />
            </div>
        </a-modal>
    </div>
</template>

<script>
export default {
    name: 'AddressInfo',
    data() {
        return {
            address: null,
            city: "",
            modalOpen: false,
        };
    },
    methods: {

        openModal() {
            this.city = "";
            this.modalOpen = true;
        },


        saveAddress() {
            this.address = ` ${this.city}`;
            this.modalOpen = false;
        },


        cancel() {
            this.modalOpen = false;
        }
    },
};
</script>
