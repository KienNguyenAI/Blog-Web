<template>
    <div class="card d-flex p-0 mt-3 mb-3">
        <a href="" class="thumbnail">
            <div class="container">
                <img src="../assets/download.jpeg" alt="thumbnail" class="img-card">
            </div>

        </a>
        <div class="card-bottom">
            <div class="main">
                <div class="heading-contain  mb-3 d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <a href="" class="text-decoration-none">
                            <span class="category">QUAN ĐIỂM - TRANH LUẬN</span>
                        </a>
                        <span style="color: #c3c3c3;">&emsp;|&emsp;</span>
                        <span class="time">4 phút đọc</span>
                    </div>
                    <div class="d-flex">
                        <i class="fa-regular fa-bookmark me-3" style="color: #c3c3c3; cursor: pointer;"
                            onclick="this.classList.toggle('fa-solid')"></i>
                        <i class="fa-solid fa-ellipsis-vertical" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="content">
                    <div class="text">
                        <a href="" class="text-decoration-none">
                            <h1 class="title">HCTVPG #6 - Vì sao bạn sẽ muốn đuổi Shakyamuni ra khỏi nhà?</h1>
                        </a>
                    </div>
                    <div class="description">
                        Hồi đó tôi luôn có một thắc mắc kỳ lạ rằng liệu Shakyamuni sẽ ở với tôi được bao lâu. Ba ngày?
                        Một tiếng? Hay 15 phút?...
                    </div>
                </div>
            </div>
            <div class="post-details d-flex justify-content-center align-items-center ">
                <a href="" class="me-3">
                    <a-avatar :size="48">

                    </a-avatar>
                </a>
                <div class="details">
                    <div class="author mb-1">
                        <a href="" class="text-decoration-none text-black fw-bold">Trịnh Trần Phương Tuấn</a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="create-at">17 giờ trước</div>
                        <div class="interactions d-flex">
                            <div class="me-2">
                                <i class="fa-regular fa-bookmark me-1" style="color: #c3c3c3; cursor: pointer;"
                                    onclick="this.classList.toggle('fa-solid')"></i>
                                <span style="font-size: .75rem;">5</span>
                            </div>
                            <div class="me-2">
                                <i class="fa-regular fa-eye me-1"></i>
                                <span style="font-size: .75rem;">5</span>
                            </div>
                            <div class="me-2">
                                <i class="fa-regular fa-comment me-1"></i>
                                <span style="font-size: .75rem;">5</span>
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
    display: flex;
    box-shadow: 0 0.25rem 0.375rem rgba(0, 0, 0, 0.1);
}

.thumbnail {
    flex: 0 0 22rem;
    width: 22rem;
    height: 11rem;
    overflow: hidden;
    margin-right: 1rem;
}

.container {
    position: relative;
    width: 100%;
}

.img-card {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 0.025rem solid #dbdbdb;
}

.card-bottom {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    margin-bottom: .5rem;
}

.category,
.time {
    font-size: 0.75rem;
    color: #4d4d4d;
}

.category:hover {
    font-weight: bold;
}

.title {
    font-size: 1.25rem;
    color: black;
    margin-bottom: .5rem;
    max-height: 3rem;
    overflow: hidden;
    text-overflow: ellipsis;
}

.description {
    overflow-y: auto;
    max-height: 3rem;
    color: #666;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: .5rem;
}


.details {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
}

.create-at {
    font-size: .75rem;
    color: #4d4d4d;
}
</style>