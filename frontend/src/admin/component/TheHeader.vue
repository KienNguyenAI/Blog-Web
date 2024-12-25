<template>
    <div class="shadow">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 col-6 d-flex align-items-center justify-content-start">
                    <a href="/admin"> <img src="../../assets/logo.webp" alt="" style="width: 5rem;"></a>
                    <span class="fw-bold">Admin</span>
                </div>
                <div class="col-sm-6 col-6 d-sm-flex align-items-center justify-content-sm-end">
                    <router-link to="/login">
                        <button class="btn">Đăng xuất</button>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.btn {
    background-color: #da5600;
    border: none;
    color: white;
    padding: .75rem 2rem;
    border-radius: 2rem;
    cursor: pointer;
}

.btn:hover {
    background-color: #a34f17;
}
</style>
