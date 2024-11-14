<template>
    <div class="header">
        <div class="container">
            <div class="row ">
                <div class="col-sm-8 col-6 d-sm-flex align-items-center justify-content-sm-start">

                    <a href=""> <img src="../assets/vue.svg" alt=""></a>

                </div>
                <div class="col-sm-4 col-6 d-sm-flex align-items-center  justify-content-sm-end">
                    <router-link to="/signup" class="text-decoration-none">
                        <span class="signin m-sm-3 d-none d-sm-flex">Đăng ký</span>
                    </router-link>

                    <router-link to="/login" class="text-decoration-none">
                        <span class="login d-flex justify-content-center">Đăng nhập</span>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import '../style/theHeader.css';
</script>