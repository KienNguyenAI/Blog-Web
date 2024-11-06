<template>
    <div class="card flex">
        <div class="row">
            <div class="col-4 align-items-center justify-content-center">
                <img src="../assets/download.jpeg" alt="" class="img-card">
            </div>
            <div class="col-8 ps-0">
                <div class="row mb-1">
                    <div class=" col-10 d-flex ">
                        <span class="category">QUAN ĐIỂM - TRANH LUẬN</span>
                        <span class="time"> 4 phút đọc</span>
                    </div>
                    <div class="col-2 justify-content-end">
                        <i class="fa-regular fa-bookmark me-3" style="color: #c3c3c3;"
                            onclick="this.classList.toggle('fa-solid')"></i>
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </div>
                </div>
                <div class="row mb-1">
                    <span class="title">HCTVPG #6 - Vì sao bạn sẽ muốn đuổi Shakyamuni ra khỏi nhà?</span>
                </div>
                <div class="row mb-4">
                    <span class="description">Hồi đó tôi luôn có một thắc mắc kỳ lạ rằng liệu Shakyamuni sẽ ở với tôi
                        được bao lâu. Ba ngày? Một tiếng? Hay 15 phút?...</span>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="avatar-container">
                            <img src="../assets/download.jpeg" alt="Avatar" class="avatar-image">
                        </div>

                    </div>
                    <div class="col-10 p-0 d-flex flex-column justify-content-center">
                        <div class="row ">
                            <div class=" col-10 d-flex ">
                                <span class="username">Trịnh Trần phương tuấn</span>
                                <span class="time"> 4 phút đọc</span>
                            </div>
                            <div class="col-2 justify-content-end p-0">
                                <i class="fa-regular fa-bookmark me-3" style="color: #c3c3c3;"
                                    onclick="this.classList.toggle('fa-solid')"></i>
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.card {
    width: 100%;
    height: 13rem;
    box-shadow: 0 0.25rem 0.375rem rgba(0, 0, 0, 0.1);
}

.img-card {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 0.025rem solid #dbdbdb;
}

.category {
    margin-right: 1rem;
    font-size: 0.75rem;
    color: #4d4d4d;
}

.category:hover {
    font-weight: bold;
}

.time {
    font-size: 0.75rem;
    color: #b4b4b4;
}

.title {

    padding: 0.5rem;
    font-size: 1.25rem;
    font-weight: bold;

}

.description {
    font-size: 0.875rem;
    color: #4d4d4d;
}

.avatar-container {
    width: 3rem;
    height: 3rem;
    overflow: hidden;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.username {
    padding-right: 0.5rem;
    font-size: 0.875rem;
    font-weight: bold;
}
</style>