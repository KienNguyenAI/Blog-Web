<template>
    <div class="container">
        <div class="user-profile">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="profile-left p-4 ">
                        <div class=" profile-content">
                            <div class="avatar-container">
                                <img src="@/assets/download.jpeg" alt="Avatar" class="avatar-user rounded-circle">
                            </div>
                            <div class="mt-3 d-flex mt-3">
                                <span class="display-name">DinoFox</span>
                            </div>
                            <div class="d-flex">
                                <span class="user-name">@{{ "DinoFox" }}</span>
                            </div>
                            <button class="profile-edit text-black">Chỉnh sửa trang cá nhân</button>
                            <div class="profile-info_stats d-flex justify-content-between mt-3">
                                <div class="item">
                                    <div class="profile-info_stats-value fw-bold">
                                        0
                                    </div>
                                    <div class="profile-info_stats-text">
                                        followers
                                    </div>

                                </div>
                                <div class="item">
                                    <div class="profile-info_stats-value fw-bold">
                                        0
                                    </div>
                                    <div class="profile-info_stats-text">
                                        following
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-9 col-12">
                    a
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.user-profile {
    margin-top: 2rem;
    border: .0125rem solid #e8e8e8;
    border-radius: .5rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}



.avatar-user {
    width: 7rem;
    height: 7rem;
}

.display-name {
    font-weight: 700;
    font-size: 1.25rem;
}

.user-name {
    color: #a9a9a9;
    font-weight: 700;
    font-size: .875rem;
}

.profile-left {
    background-color: #f9f9f9;

}

.profile-content button {
    width: 100%;
    padding-top: .75rem;
    padding-bottom: .75rem;
    padding-right: 1rem;
    padding-left: 1rem;
    margin-top: 1rem;
    border: .0125rem solid #e8e8e8;
    border-radius: .25rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.profile-content button:hover {
    cursor: pointer;
    background-color: #dfdfdf;
}

@media (max-width: 992px) {


    .profile-content {
        margin: auto;
        margin-right: 10rem;
        margin-left: 10rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;

    }
}

@media (max-width: 768px) {

    .profile-content {
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;

    }
}
</style>
