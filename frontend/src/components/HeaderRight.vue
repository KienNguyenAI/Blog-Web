<template>

    <div class="d-flex align-items-center" v-if="!isLoggedIn">
        <router-link to="/createAccount" class="text-decoration-none pe-0">
            <span class="signin m-sm-3 d-none d-sm-flex">Đăng ký</span>
        </router-link>

        <router-link to="/login" class="text-decoration-none">
            <span class="login d-flex justify-content-center">Đăng nhập</span>
        </router-link>
    </div>


    <div v-if="isLoggedIn" class="d-flex justify-content-end ">
        <router-link class=" write-button me-1 ms-1" to="/post">
            <i class="fa-solid fa-feather me-2"></i>
            <span>Viết bài</span>
        </router-link>
        <a-dropdown trigger="click">
            <div class="ant-dropdown-link" style="cursor: pointer;">
                <img :src="getAvatar(user.avatar)" alt="Avatar" class="rounded-circle"
                    style="width: 2.5rem; height: 2.5rem;">
                <CaretDownOutlined style="font-size: .5rem;" />
            </div>
            <template #overlay>
                <a-card class="card-dropdown " style="width: 300px;">
                    <div class="nav-user-details  mb-3">
                        <img :src="getAvatar(user.avatar)" alt="" class="user-avatar me-3">
                        <div class="user-info w-100">
                            <div class=" d-flex">
                                <span class="display-name">{{ user.name }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="user-name">@{{ user.username }}</span>
                            </div>

                            <router-link :to="`/account/${user.username}`" class="p-0">
                                <button class="view-profile-button mt-1 text-black">
                                    Xem trang cá nhân
                                </button>
                            </router-link>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="nav-user-contents">
                        <div class="content">
                            <i class="fa-regular fa-newspaper fa-lg me-2"></i>
                            <span>Bài viết của tôi</span>
                        </div>

                        <div class="content">
                            <i class="fa-solid fa-copy fa-lg me-2"></i>
                            <span>Nháp của tôi</span>
                        </div>
                        <div class="content">
                            <i class="fa-regular fa-bookmark fa-lg me-2"></i>
                            <span>Đã lưu</span>
                        </div>
                        <div class="content">
                            <i class="fa-solid fa-gear fa-lg me-2"></i>
                            <span>Tùy chỉnh tài khoản</span>
                        </div>
                        <hr class="my-2">
                        <div class="content" @click="logout">
                            <i class="fa-solid fa-right-from-bracket fa-lg me-2"></i>
                            <span>Đăng xuất</span>
                        </div>
                    </div>
                </a-card>
            </template>
        </a-dropdown>
        <!-- Dropdown with image and icon -->
    </div>
</template>

<script>
import { CaretDownOutlined } from '@ant-design/icons-vue';
import { isLoggedIn, getUser, logout } from '../services/auth';
export default {
    components: {
        CaretDownOutlined,

    },
    props: {
        showShadow: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            isLoggedIn: false,
            user: null
        };
    },
    mounted() {
        this.checkLoginStatus();
    },
    methods: {

        checkLoginStatus() {
            this.isLoggedIn = isLoggedIn();
            if (this.isLoggedIn) {
                this.user = getUser();
            }
        },

        logout() {
            logout();
            this.isLoggedIn = false;
            this.user = null;
        },
        getAvatar(avatar) {

            return avatar ? avatar : '/avatars/default.webp';
        },

    }
}
</script>

<style>
.login {
    padding: 0.75rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    background-color: #ff7919;
    color: white;
    font-size: 1.1rem;
    border-radius: 1.45rem;
}

.login:hover {
    background-color: #da5600;
}

.signin {
    color: black;
    font-size: 1.1rem;
}


.nav-user-details {
    display: flex;
    flex-direction: row;
}

.nav-user-details img {
    width: 3rem;
    height: 3rem;
    border-radius: .5rem;
}

.user-info .display-name {
    font-weight: 700;
    font-size: 1rem;
}

.user-info .user-name {
    color: #a9a9a9;
    font-weight: 700;
    font-size: .8rem;
}

.view-profile-button {
    width: 100%;
    background-color: white;
    cursor: pointer;
    font-size: 1rem;
    padding: .5rem;
    border: 1.5px solid #eaeaef;
    border-radius: 1rem;
}

.view-profile-button:hover {
    background-color: #eaeaef;
}

.nav-user-contents .content {
    padding: .5rem;
    cursor: pointer;
}

.nav-user-contents .content:hover {
    background-color: #eaeaef;
    border-radius: .5rem;
}

.nav-user-contents .content span {
    font-size: 1.1rem;
    color: black
}

.write-button {

    color: black;
    padding: .7rem;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    border: 1.5px solid #eaeaef;
    border-radius: 1.5rem;
}

.write-button:hover {
    background-color: #eaeaef;
}
</style>
