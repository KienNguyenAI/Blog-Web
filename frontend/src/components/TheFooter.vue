<template>
    <div class="container-fluid footer p-0 mt-5">
        <div class="container footer-container">
            <div class="footer-header d-flex">
                <a href="" class="ps-0"> <i class="fa-brands fa-facebook fa-lg " style="color: #009dff;"></i></a>
                <a href=""><i class="fa-brands fa-google fa-lg " style="color: #009dff;"></i></a>
                <a href=""><i class="fa-brands fa-github fa-lg" style="color: #009dff;"></i></a>
            </div>
            <div class="footer-description mt-4">
                FoxTales là web chia sẻ kiến thức, nơi người dùng đăng bài, thảo luận và học hỏi từ cộng đồng về
                các lĩnh vực như giáo dục, tư duy và phát triển cá nhân.
            </div>
            <div class="footer-contact mt-4">
                <span>Liên hệ với tôi qua số điện thoại: </span>
                <a href="tel:+84347173486" class="footer-phone">034 717 3486</a>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style>
.footer {
    box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2);
}

.footer-container {
    padding-top: 4rem;
    padding-bottom: 4rem;
}

.footer-description {
    width: 50%;
    font-size: .85rem;
}

.footer-contact {
    font-size: .85rem;
    color: #333;
}

.footer-phone {
    color: #009dff;
    text-decoration: none;
    font-weight: bold;
}

.footer-phone:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .footer-container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .footer-description {
        width: 100%;
        font-size: 0.8rem;
    }

    .footer-contact {
        font-size: 0.8rem;
    }
}
</style>
