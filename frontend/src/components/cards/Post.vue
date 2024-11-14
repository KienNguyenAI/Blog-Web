<template>
    <div class="container">
        <div class="post-container">
            <div class="d-flex align-items-center">
                <a href="" class="text-decoration-none p-0">
                    <span class="category text-black">QUAN ĐIỂM - TRANH LUẬN</span>
                </a>
                <span style="color: #c3c3c3;">&emsp;|&emsp;</span>
                <span class="time">4 phút đọc</span>
            </div>
            <div class="post-title">
                <a href="" class="title text-black">
                    Liệu có phải MỤC ĐÍCH CUỘC ĐỜI là HƯỚNG ĐẾN KHOÁI LẠC?
                </a>
            </div>
            <img src="../../assets/testimg.png" alt="" class="img-post">
            <div class="editor"></div>
            <div class="post-read-info d-flex mb-3">
                <div>
                    <a href="" class="text-primary  p-0 fs-5">
                        <span>Đọc tiếp</span>
                        <span style="color: #c3c3c3;">&emsp;|&emsp;</span>
                        <span>4 phút đọc</span>
                    </a>

                </div>
            </div>
            <div class="d-flex justify-content-between">
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
</template>

<style>
.post-container {
    margin-right: 15.5rem;
    margin-left: 15.5rem;
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #e8e8e8;

}

.category,
.time {
    font-size: 0.75rem;
    color: #4d4d4d;
}

.category:hover {
    font-weight: bold;
}

.post-title {
    margin-top: 1rem;
    margin-bottom: 1rem;

}

.post-title {
    font-size: 2rem;
    font-weight: bold;
    color: black;
    padding: 0;

}

.img-post {
    max-width: 100%;
    height: auto;
}

@media (max-width: 768px) {
    .post-container {
        margin: 0;
        margin-top: 2rem;
    }

    .post-title {
        font-size: 1.5rem;
    }

    .post-read-info span {
        font-size: 1rem;
    }
}
</style>