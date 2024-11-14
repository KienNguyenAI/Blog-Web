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
                            <a-input size="large" placeholder="Tên tài khoản hoặc email" class="mb-3" />
                            <a-input-password size="large" placeholder="Mật khẩu" class="mb-3"></a-input-password>

                            <a-button size="large" type="primary" class="mb-3" style="width: 100%;">Đăng nhập</a-button>

                            <router-link to="/forgotPassword" class="text-decoration-none mb-3 text-start w-100">
                                <a href="" class=" text-primary text-decoration-none">Quên mật khẩu?</a>
                            </router-link>

                            <span class="mb-3 text-start w-100" style="color: #4d4d4d;">Chưa có tài khoản?
                                <router-link to="/signup" class="text-decoration-none ">
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

<style scoped>
@import "@/style/login.css";
</style>