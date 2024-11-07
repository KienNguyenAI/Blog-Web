<template>
    <form action="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 col-12">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="items col-sm-6 col-12 d-flex flex-column pt-5 align-items-center justify-content-center"
                            style="height: 100vh;">
                            <router-link to="/user" class="mb-5">
                                <img src="../../assets/vue.svg" alt="" class="img-fluid">
                            </router-link>
                            <!-- User information -->
                            <a-input size="large" placeholder="Tên đăng nhập" class="mb-3" />
                            <a-input size="large" placeholder="Tên hiển thị" class="mb-3" />
                            <!-- Password -->
                            <a-input-password size="large" placeholder="Mật khẩu" class="mb-3"></a-input-password>
                            <a-input-password size="large" placeholder="Nhập lại mật khẩu"
                                class="mb-3"></a-input-password>


                            <a-collapse style="width: 100%;">
                                <a-collapse-panel header="Nhấn vào để thêm input">
                                    <!-- Sử dụng thuộc tính block để nút full chiều ngang -->
                                    <a-button size="large" @click="showInputs = !showInputs" block class="mb-3"
                                        style="background-color: #f2f2f2;">
                                        Thêm thông tin khác
                                    </a-button>
                                    <transition name="slide-down">
                                        <div v-if="showInputs">
                                            <a-form-item label="Input 1">
                                                <a-input size="large" placeholder="Số điện thoại" class="mb-3" />
                                            </a-form-item>
                                            <a-form-item label="Input 2">
                                                <a-input size="large" placeholder="Số chứng minh nhân dân"
                                                    class="mb-3" />
                                            </a-form-item>
                                        </div>
                                    </transition>
                                </a-collapse-panel>
                            </a-collapse>

                            <a-button size="large" type="primary" class="mb-3" style="width: 100%;">Đăng ký</a-button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>


<script>
import { ref } from 'vue';

export default {
    setup() {
        const showInputs = ref(false);
        const input1 = ref('');
        const input2 = ref('');

        return { showInputs, input1, input2 };
    }
};
</script>

<style scoped>
@import "../../style/login.css";
</style>
