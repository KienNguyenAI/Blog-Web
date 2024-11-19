<template>
    <div class="container pe-4 ps-4">
        <label for="" class="fw-bold text-secondary">DANH SÁCH SERIES</label>

        <a-button v-if="!showAddSeries" type="dashed" class="w-100 fw-bold mt-3"
            style="height: 3.5rem; font-size: 1.125rem;" @click="showAddSeries = true">
            Thêm series
        </a-button>

        <div v-if="showAddSeries" class="add-series shadow p-5 d-flex justify-content-center">
            <div class="content w-100">
                <span class="title fw-bold text-center w-100 d-flex justify-content-center">
                    Thêm Series mới
                </span>
                <div class="series-name mt-4">
                    <label for="name" class="fw-bold text-secondary" style="font-size: .75rem;">TÊN HIỂN THỊ</label>
                    <a-input size="large" placeholder="Be creative.." class="mt-3 w-100" />
                </div>
                <div class="series-description mt-4">
                    <label for="name" class="fw-bold text-secondary" style="font-size: .75rem;">MÔ TẢ</label>
                    <a-textarea placeholder="Tóm tắt ngắn gọn..." class="mt-3 w-100" :rows="3" />
                </div>
                <div class="series-description mt-4">
                    <label for="name" class="fw-bold text-secondary" style="font-size: .75rem;">Chọn bài viết của series
                        (ấn vào tiêu đề bài viết để chọn/ bỏ chọn)</label>
                </div>
                <div class="submit-series mt-3 d-flex justify-content-end">
                    <button class="cancel-series me-3" @click="cancelAddSeries">Hủy</button>
                    <button class="create-series">Tạo</button>
                </div>
            </div>
        </div>
        <div class=" mt-5 d-flex justify-content-end">
            <button class="confirm">Hoàn tất</button>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            showAddSeries: false,
        };
    },
    methods: {
        cancelAddSeries() {
            this.showAddSeries = false;
        }
    }
};
</script>

<style>
.add-series {
    align-items: center;
    justify-content: center;
}

.submit-series button {
    padding: 1rem;
    border: 0;
    border-radius: 1.25rem;
    cursor: pointer;
}

.submit-series .cancel-series {
    background-color: white;
}

.submit-series .cancel-series:hover {
    background-color: #edf2f7;
}

.submit-series .create-series {
    background-color: #ff7919;
    color: white;
}

.submit-series .create-series:hover {
    background-color: #da5600;
}

.confirm {
    background-color: #ff7919;
    color: white;
    padding: 1rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;

    border: 0;
    border-radius: 1.5rem;
    cursor: pointer;
}

.confirm:hover {
    background-color: #da5600;
}
</style>