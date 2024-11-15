<template>
    <div class="container">
        <div class="user-profile">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="profile-left p-4">
                        <div class="profile-content">
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
                                <div class="item1">
                                    <div class="profile-info_stats-value fw-bold">
                                        0
                                    </div>
                                    <div class="profile-info_stats-text">
                                        followers
                                    </div>
                                </div>
                                <div class="item2">
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
                    <div class="profile-right mt-3">
                        <div class="profile-tabs d-flex justify-content-between">
                            <div class="profile-tabs_items d-flex">
                                <a href="#" class="item" :class="{ active: activeTab === 'post' }"
                                    @click="setActiveTab('post')">
                                    <i class="fa-solid fa-pencil icon"></i>
                                    <span class="text">Bài viết</span>
                                </a>
                                <a href="#" class="item " :class="{ active: activeTab === 'series' }"
                                    @click="setActiveTab('series')">
                                    <i class="fa-solid fa-book icon"></i>
                                    <span class="text">Series</span>
                                </a>
                                <a href="#" class="item d-none d-sm-block" :class="{ active: activeTab === 'saved' }"
                                    @click="setActiveTab('saved')">
                                    <i class="fa-solid fa-bookmark icon"></i>
                                    <span class="text">Đã Lưu</span>
                                </a>
                            </div>
                            <a-dropdown>
                                <a class="ant-dropdown" @click.prevent>
                                    <i class="fa-solid fa-ellipsis-vertical p-3"
                                        style="cursor: pointer; color: #898989;"></i>
                                    <DownOutlined />
                                </a>
                                <template #overlay>
                                    <a-menu>
                                        <a-menu-item class="p-2">
                                            <a href="#" style="font-size: 1rem;">Người theo dõi</a>
                                        </a-menu-item>
                                        <a-menu-item class="p-2">
                                            <a href="#" style="font-size: 1rem;">Đang theo dõi</a>
                                        </a-menu-item>
                                        <a-menu-item class="p-2">
                                            <a href="#" style="font-size: 1rem;">Nháp</a>
                                        </a-menu-item>
                                    </a-menu>
                                </template>
                            </a-dropdown>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activeTab: 'post',
        };
    },
    methods: {
        setActiveTab(tab) {
            this.activeTab = tab;
        },
    },
};
</script>

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

.profile-tabs {
    border-bottom: 1.25px solid #e0e0e0;
    margin-top: 1rem;
    margin-bottom: 1rem;
}

.profile-tabs .item {
    text-decoration: none;
    padding: 1rem;
    display: flex;
    align-items: center;
}

.profile-tabs .text {
    color: #898989;
    font-size: 1rem;
    font-weight: 600;
}

.profile-tabs .icon {
    color: #898989;
    font-size: 1rem;
    margin-right: .5rem;
}

.profile-tabs .item.active .icon {
    color: #0090d4;
}

.profile-tabs .item.active .text {
    color: #0090d4;
}

.profile-tabs .item.active {
    border-bottom: 3px solid #0090d4;
    padding-bottom: 10px;
}

.profile-tabs .item:hover .text,
.profile-tabs .item:hover .icon {
    color: #0090d4;
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

    .profile-info_stats .item1 {
        margin-right: 5rem;
    }

    .profile-tabs {
        flex-direction: r;
        align-items: flex-start;
    }

    .profile-tabs .text {
        font-size: .75rem;
    }
}
</style>
