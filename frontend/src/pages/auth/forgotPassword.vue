<template>
    <form action="" @submit.prevent="check">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 col-12">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="items col-sm-6 col-12 d-flex flex-column pt-5 align-items-center justify-content-center"
                            style="height: 100vh;">
                            <router-link to="/" class="mb-5">
                                <img src="../../assets/vue.svg" alt="" class="img-fluid" />
                            </router-link>

                            <span class="mb-3 text-start w-100" style="color: #4d4d4d; font-size: 0.85rem;">Vui lòng
                                nhập địa chỉ email của bạn để được cấp lại mật khẩu</span>

                            <!-- Liên kết email với v-model -->
                            <div class="mb-3 w-100">
                                <a-input size="large" placeholder="email@example.com" class="mb-1" v-model:value="email"
                                    :class="{ 'is-invalid': errors.email }" />
                                <span v-if="errors.email" class="error-text">{{ errors.email[0] }}</span>
                            </div>
                            <div class="mb-3 w-100">
                                <a-input-password size="large" placeholder="Mật khẩu mới" class="mb-1"
                                    v-model:value="password" :class="{ 'is-invalid': errors.password }" />
                                <span v-if="errors.password" class="error-text">{{ errors.password[0] }}</span>
                            </div>
                            <!-- Password Confirmation -->
                            <div class="mb-3 w-100">
                                <a-input-password size="large" placeholder="Nhập lại mật khẩu" class="mb-1"
                                    v-model:value="password_confirmation"
                                    :class="{ 'is-invalid': errors.password_confirmation }" />
                                <span v-if="errors.password_confirmation" class="error-text">{{
                                    errors.password_confirmation[0] }}</span>
                            </div>

                            <a-button size="large" type="primary" class="mb-3" style="width: 100%;" html-type="submit">
                                Đổi mật khẩu
                            </a-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import axios from "axios";
import { reactive, toRefs, ref } from "vue";
import { notification } from "ant-design-vue";
import { useRouter } from 'vue-router';
export default {
    setup() {
        const email = reactive({
            email: "",
            password: "",
            password_confirmation: "",
        });
        const router = useRouter();
        const errors = ref({});

        const check = () => {
            axios.post("http://127.0.0.1:8000/api/resetPass", email)
                .then((response) => {
                    console.log(response);
                    notification.success({
                        message: "Thành công",
                        description: "Mật khẩu của bạn đã được cập nhật thành công.",
                        duration: 1,
                        style: {
                            backgroundColor: '#f6ffed',
                        }
                    });
                    setTimeout(() => {
                        router.push('/');
                    }, 1000);
                })
                .catch((error) => {
                    console.log(error);
                    errors.value = error.response.data.errors;
                });
        };

        return {
            check,
            ...toRefs(email),
            errors,
        };
    },
};
</script>

<style scoped>
@import "@/style/login.css";

.is-invalid {
    border: 1px solid red !important;
}

.error-text {
    color: red;
    font-size: 0.875rem;
    margin-top: 4px;
    display: block;
}
</style>