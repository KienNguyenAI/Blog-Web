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
                            <a-input-password size="large" placeholder="Nhập mật khẩu mới"
                                class="mb-3"></a-input-password>
                            <a-input-password size="large" placeholder="Nhập lại mật khẩu"
                                class="mb-3"></a-input-password>

                            <a-button size="large" type="primary" class="mb-3" style="width: 100%;">Đăng nhập</a-button>

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