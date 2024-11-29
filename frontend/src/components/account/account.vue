<template>
    <div class="container">
        <div class="user-profile">
            <div class="row">
                <div class="col-lg-3 col-12">
                    <div class="profile-left p-4">
                        <div class="profile-content">
                            <div class="avatar-container">
                                <img :src="getAvatar(user.avatar)" alt="Avatar" class="avatar-user rounded-circle">
                            </div>
                            <div class="mt-3 d-flex mt-3">
                                <span class="display-name">{{ user.name }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="user-name">@{{ user.username }}</span>
                            </div>
                            <router-link to="/account/setting" class="p-0" v-if="showEditProfile">
                                <button class="profile-edit text-black">Chỉnh sửa trang cá nhân</button>
                            </router-link>
                            <a-button type="primary" size="large" class="w-100 border-0 mt-3"
                                style="background-color: #e0f2fe;" ghost v-if="showFollowButton"
                                @click="followUser">Theo dõi</a-button>
                            <a-button type="primary" size="large" class="w-100 border-0 mt-3"
                                style="background-color: #e0f2fe;" ghost v-if="!showEditProfile && !showFollowButton"
                                @click="unfollowUser">
                                Đang theo dõi
                            </a-button>
                            <div class="profile-info_stats d-flex justify-content-between mt-3">
                                <div class="item1">
                                    <div class="profile-info_stats-value fw-bold">
                                        {{ user.followers }}
                                    </div>
                                    <div class="profile-info_stats-text">
                                        followers
                                    </div>
                                </div>
                                <div class="item2">
                                    <div class="profile-info_stats-value fw-bold">
                                        {{ user.following }}
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
                                <!-- <a href="#" class="item " :class="{ active: activeTab === 'series' }"
                                    @click="setActiveTab('series')">
                                    <i class="fa-solid fa-book icon"></i>
                                    <span class="text">Series</span>
                                </a> -->
                                <a href="#" class="item d-none d-sm-block" :class="{ active: activeTab === 'saved' }"
                                    @click="setActiveTab('saved')" v-if="loginUser === user.id">
                                    <i class="fa-solid fa-bookmark icon"></i>
                                    <span class="text">Đã Lưu</span>
                                </a>
                            </div>
                            <!-- <a-dropdown>
                                <a class="ant-dropdown" @click.prevent>
                                    <i class="fa-solid fa-ellipsis-vertical p-3"
                                        style="cursor: pointer; color: #898989;"></i>
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
</a-dropdown> -->
                        </div>
                    </div>
                    <div class="profile-content pe-4">
                        <!-- Hiển thị MyPosts khi activeTab là 'post' -->
                        <MyPosts v-if="activeTab === 'post'" />

                        <!-- Hiển thị Saved khi activeTab là 'saved' -->
                        <Saved v-if="activeTab === 'saved'" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { notification } from 'ant-design-vue';
import Saved from './saved.vue';
import MyPosts from './MyPosts.vue';
import { getUser } from '../../services/auth';
export default {
    components: {
        Saved,
        MyPosts,
    },
    data() {
        return {
            activeTab: 'post',
            user: {
                name: '',
                username: '',
                avatar: '',
                followers: 0,
                following: 0,
            },
            showEditProfile: false,
            showFollowButton: true,
            loginUser: getUser().id,
        };
    },
    mounted() {
        const username = this.$route.params.username;
        this.fetchUserData(username);
    },
    watch: {
        '$route.params.username': 'fetchUserData',
    },
    methods: {
        setActiveTab(tab) {
            this.activeTab = tab;
        },
        fetchUserData(username) {
            axios.get(`http://127.0.0.1:8000/api/user/${username}`)
                .then(response => {
                    if (response.data) {
                        const user = JSON.parse(localStorage.getItem('user'));

                        const userData = response.data[0];
                        const followingCount = response.data.following_count;
                        const followerCount = response.data.follower_count;

                        this.user.id = userData.id;
                        this.user.name = userData.name;
                        this.user.username = userData.username;
                        this.user.avatar = userData.avatar;
                        this.user.followers = followerCount;
                        this.user.following = followingCount;

                        if (user && user.id === userData.id) {
                            this.showEditProfile = true;
                            this.showFollowButton = false;
                        } else {
                            this.showEditProfile = false;
                            this.showFollowButton = true;
                            this.checkFollow();
                        }
                    }
                })
                .catch(error => {
                    console.error('Lỗi lấy dữ liệu người dùng', error);
                });
        },

        followUser() {
            const currentUser = JSON.parse(localStorage.getItem('user'));
            const follow = {
                follower: currentUser.id,
                following: this.user.id
            };

            axios.post('http://127.0.0.1:8000/api/follow', follow)
                .then((response) => {

                    if (response.data.message === 'Followed successfully') {
                        this.checkFollow();
                        this.user.followers += 1;
                        notification.success({
                            message: `Đã theo dõi người viết`,
                            duration: 1,
                            style: {
                                backgroundColor: '#f6ffed',
                            }
                        });
                    }
                })
                .catch((error) => {
                    console.error('Lỗi khi thực hiện follow:', error);
                });
        },
        unfollowUser() {
            const currentUser = JSON.parse(localStorage.getItem('user'));
            const follow = {
                follower: currentUser.id,
                following: this.user.id
            };

            axios.post('http://127.0.0.1:8000/api/unfollow', follow)
                .then((response) => {
                    if (response.data.message === 'Unfollowed successfully') {
                        this.user.followers -= 1;
                        this.showFollowButton = true;
                        notification.success({
                            message: `Đã hủy theo dõi người viết`,
                            duration: 1,
                            style: {
                                backgroundColor: '#f6ffed',
                            }
                        });
                    }
                })
                .catch((error) => {
                    console.error('Lỗi khi thực hiện unfollow:', error);
                });
        },
        checkFollow() {
            const currentUser = JSON.parse(localStorage.getItem('user'));
            const follow = {
                follower: currentUser.id,
                following: this.user.id
            };

            axios.post('http://127.0.0.1:8000/api/checkFollow', follow)
                .then(response => {
                    this.showFollowButton = !response.data.isFollowing;
                })
                .catch(error => {
                    console.error("Error checking follow status:", error);
                });
        },
        getAvatar(avatar) {

            return avatar ? avatar : '/avatars/default.webp';
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
    height: 100%;
    background-color: #f9f9f9;
}

.profile-content .profile-edit {
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

.profile-content .profile-edit:hover {
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
    color: #ff7919;
}

.profile-tabs .item.active .text {
    color: #ff7919;
}

.profile-tabs .item.active {
    border-bottom: 3px solid #ff7919;
    padding-bottom: 10px;
}

.profile-tabs .item:hover .text,
.profile-tabs .item:hover .icon {
    color: #ff7919;
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
