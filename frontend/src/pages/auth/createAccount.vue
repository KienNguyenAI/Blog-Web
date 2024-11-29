<template>
    <form action="" @submit.prevent="check()">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 col-12">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="items col-sm-6 col-12 d-flex flex-column pt-5 align-items-center justify-content-center"
                            style="height: 100vh;">
                            <router-link to="/" class="mb-5">
                                <img src="../../assets/foxtalesLogo.webp" alt="" class="img-fluid"
                                    style="width: 10rem;">
                            </router-link>
                            <div class="mb-3 w-100">
                                <a-input size="large" placeholder="email@example.com" class="mb-1" v-model:value="email"
                                    :class="{ 'is-invalid': errors.email }" />
                                <span v-if="errors.email" class="error-text">{{ errors.email[0] }}</span>
                            </div>
                            <!-- Username -->
                            <div class="mb-3 w-100">
                                <a-input size="large" placeholder="Tên đăng nhập" class="mb-1" v-model:value="username"
                                    :class="{ 'is-invalid': errors.username }" />
                                <span v-if="errors.username" class="error-text">{{ errors.username[0] }}</span>
                            </div>
                            <!-- Display Name -->
                            <div class="mb-3 w-100">
                                <a-input size="large" placeholder="Tên hiển thị" class="mb-1" v-model:value="name"
                                    :class="{ 'is-invalid': errors.name }" />
                                <span v-if="errors.name" class="error-text">{{ errors.name[0] }}</span>
                            </div>
                            <!-- Password -->
                            <div class="mb-3 w-100">
                                <a-input-password size="large" placeholder="Mật khẩu tối thiểu 8 ký tự" class="mb-1"
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

                            <span class="mb-3 text-start w-100" style="color: #4d4d4d;">Đã có tài khoản?
                                <router-link to="/login" class="text-decoration-none">
                                    <a class="text-primary text-decoration-none">Đăng nhập</a>
                                </router-link>
                            </span>
                            <a-button size="large" type="primary" class="mb-3"
                                style="width: 100%; background-color: #ff7919;" html-type="submit">Đăng ký</a-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>


<script>
import { reactive, toRefs, ref } from 'vue';
import { notification } from 'ant-design-vue';
import { useRouter } from 'vue-router';
export default {
    setup() {
        const router = useRouter();
        const users = reactive({
            email: "",
            username: "",
            name: "",
            password: "",
            password_confirmation: ""
        })
        const errors = ref({
        });
        const check = () => {
            axios.post('http://127.0.0.1:8000/api/register', users)
                .then((response) => {
                    notification.success({
                        message: `Tạo tài khoản thành công`,
                        duration: 1,
                        style: {
                            backgroundColor: '#f6ffed',
                        }
                    });
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    router.push('/');
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                })
        }

        return {
            check,
            ...toRefs(users),
            errors
        }

    }
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
