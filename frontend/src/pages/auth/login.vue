<template>
    <form action="" @submit.prevent="check">
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
                            <!-- Username or Email -->
                            <div class="mb-3 w-100">
                                <a-input size="large" placeholder="Tên tài khoản hoặc email" class="mb-1"
                                    v-model:value="username_or_email"
                                    :class="{ 'is-invalid': errors.username_or_email }" />
                                <span v-if="errors.username_or_email" class="error-text">{{ errors.username_or_email[0]
                                    }}</span>
                            </div>

                            <!-- Password -->
                            <div class="mb-3 w-100">
                                <a-input-password size="large" placeholder="Mật khẩu" class="mb-1"
                                    v-model:value="password" :class="{ 'is-invalid': errors.password }" />
                                <span v-if="errors.password" class="error-text">{{ errors.password[0] }}</span>
                            </div>

                            <a-button size="large" type="primary" class="mb-3"
                                style="width: 100%; background-color: #ff7919;" html-type="submit">Đăng nhập</a-button>

                            <router-link to="/forgotPassword"
                                class="p-0 text-decoration-none mb-3 text-start w-100 text-primary">
                                Quên mật khẩu?
                            </router-link>

                            <span class="mb-3 text-start w-100" style="color: #4d4d4d;">Chưa có tài khoản?
                                <router-link to="/createAccount" class="text-decoration-none ">
                                    <a class="text-primary text-decoration-none">Đăng ký ngay</a>
                                </router-link>
                            </span>
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
            username_or_email: "",
            password: "",
        });

        const errors = ref({});

        const check = () => {
            axios.post('http://127.0.0.1:8000/api/login', users)
                .then((response) => {
                    notification.success({
                        message: `Đăng nhập thành công`,
                        duration: 1,
                        style: {
                            backgroundColor: '#f6ffed',
                        }
                    });
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    router.push('/');

                })
                .catch((error) => {
                    if (error.response && error.response.data.errors) {
                        errors.value = error.response.data.errors;
                    } else {
                        errors.value = { username_or_email: ['Tên tài khoản hoặc email không đúng'], password: ['Mật khẩu không đúng'] };
                    }
                });
        };

        return {
            check,
            ...toRefs(users),
            errors
        };
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
