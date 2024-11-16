<template>
    <form action="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 col-12">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="items col-sm-6 col-12 d-flex flex-column pt-5 align-items-center justify-content-center"
                            style="height: 100vh;">
                            <router-link to="/" class="mb-5">
                                <img src="../../assets/vue.svg" alt="" class="img-fluid">
                            </router-link>

                            <span class="mb-3 text-start w-100" style="color: #4d4d4d;">Đăng ký bằng email</span>
                            <a-input size="large" placeholder="email@example.com" class="mb-3" />
                            <div class="row mb-3 ">
                                <div class="col-8">
                                    <span style="font-size: 0.85rem;">Thư xác nhận sẽ được gửi vào thư tài khoản của
                                        bạn</span>
                                </div>
                                <div class="col-4">
                                    <a-button size="large" type="primary" class="mb-3"
                                        style="width: 100%;">gửi</a-button>
                                </div>
                            </div>
                            <span class="mb-3 text-start w-100" style="color: #4d4d4d;">Đã có tài khoản?
                                <router-link to="/login" class="text-decoration-none">
                                    <a class="text-primary text-decoration-none">Đăng nhập</a>
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
