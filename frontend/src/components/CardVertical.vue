<template>
    <div class="card d-flex">
        <a href="" class="thumbnail">
            <img src="../assets/download.jpeg" alt="thumbnail" class="img-card">

        </a>
        <div class="card-bottom">
            <div class="main">
                <div class="heading-contain  d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="time">4 phút đọc</span>
                    </div>
                    <div class="d-flex">
                        <i class="fa-regular fa-bookmark me-3" style="color: #c3c3c3; cursor: pointer;"
                            onclick="this.classList.toggle('fa-solid')"></i>
                        <i class="fa-solid fa-ellipsis-vertical" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="content">
                    <div class="text ">
                        <a href="" class="text-decoration-none">
                            <h1 class="title fw-bold">HCTVPG #6 - Vì sao bạn sẽ muốn đuổi Shakyamuni ra khỏi nhà?</h1>
                        </a>
                    </div>

                </div>
            </div>
            <div class="post-details d-flex justify-content-center align-items-center">
                <a href="" class="me-sm-3 p-0" v-if="!isInSlider">
                    <img src="../assets/download.jpeg" alt="Avatar" class="rounded-circle avatar">
                </a>
                <div class="details ms-2">
                    <div class="author mb-1">
                        <a href="" class="text-decoration-none text-black p-0 author-name">Trịnh Trần Phương
                            Tuấn</a>
                    </div>
                    <div class="d-flex justify-content-between " v-if="!isInSlider">
                        <div class="create-at">17 giờ trước</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isInSlider: {
            type: Boolean,
            default: false
        }
    }
}
</script>
<style scoped>
.card {
    width: 100%;
    display: flex;
    flex-direction: column;
    padding-top: 1.875rem;
    padding-bottom: 1.875rem;
}

.thumbnail {
    width: 100%;
    height: 11rem;
    overflow: hidden;
    margin-right: 1rem;
    padding: 0;
}

.img-card {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 0.025rem solid #dbdbdb;
    border-radius: .3rem;
}

.card-bottom {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    margin-top: .5rem;
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

.details {
    display: flex;
    flex-grow: 1;
    flex-direction: column;
}

.create-at {
    font-size: .75rem;
    color: #4d4d4d;
}

.avatar {
    width: 3rem;
    height: 3rem;
}

/* Media query cho màn hình nhỏ hơn 768px */
@media (max-width: 768px) {
    .card {
        flex-direction: row;
        padding-top: 1rem;
        padding-bottom: 1em;
    }

    .thumbnail {
        height: 6.25rem;

    }

    .title {
        font-size: .9375rem;
        max-height: 2rem;

    }

    .avatar {
        width: 2rem;
        height: 2rem;
    }

    .author-name {
        font-size: .75rem;
    }

}
</style>