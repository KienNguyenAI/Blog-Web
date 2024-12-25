<template>
    <div class="container">
        <!-- Cover Upload -->
        <label class="cover-upload" ref="coverUpload">
            <CameraOutlined class="large-icon" />
            <span class="text-white">Thay đổi ảnh bìa</span>
            <input type="file" accept="image/*" @change="handleImageChange($event, 'coverUpload')" />
        </label>

        <div class="form-inner p-4">
            <div class="d-flex justify-content-between mb-5">
                <!-- Avatar Upload -->
                <label class="avatar-upload" ref="avatarUpload">
                    <CameraOutlined class="large-icon" />
                    <input type="file" accept="image/*" @change="handleImageChange($event, 'avatarUpload')" />
                </label>
                <div class="textarea">
                    <a-textarea :rows="4" :maxlength="150" show-count style="height: 100%;"
                        v-model:value="description" />
                </div>
            </div>
            <div class="d-grid gap-3 mb-5" style="grid-template-columns: repeat(2, 1fr);">
                <div class="user-info">
                    <label for="name" class="fw-bold text-secondary">Tên người dùng</label>
                    <a-input v-model:value="userInfo.name" size="large" class="mt-3 " disabled />
                </div>
                <div class="user-info">
                    <label for="email" class="fw-bold text-secondary">Email</label>
                    <a-input v-model:value="userInfo.email" size="large" class="mt-3" disabled />
                </div>
                <div class="user-info">
                    <label for="dob" class="fw-bold text-secondary">Ngày sinh</label>
                    <div class="d-flex mt-3">
                        <a-select v-model:value="dob.day" class="me-2" placeholder="Ngày" size="large" style="flex: 1;">
                            <a-select-option v-for="n in 31" :key="n" :value="n">{{ n }}</a-select-option>
                        </a-select>
                        <a-select v-model:value="dob.month" class="me-2" placeholder="Tháng" size="large"
                            style="flex: 1;">
                            <a-select-option v-for="n in 12" :key="n" :value="n">{{ n }}</a-select-option>
                        </a-select>
                        <a-select v-model:value="dob.year" class="me-2" placeholder="Năm" size="large" style="flex: 1;">
                            <a-select-option v-for="n in 100" :key="2024 - n" :value="2024 - n">{{ 2024 - n
                                }}</a-select-option>
                        </a-select>
                    </div>
                </div>
                <div class="user-info">
                    <label for="gender" class="fw-bold text-secondary">Giới tính</label>
                    <a-radio-group v-model:value="gender" size="large" class="mt-3" style="display: flex; gap: 15px;">
                        <a-radio value="male">Nam</a-radio>
                        <a-radio value="female">Nữ</a-radio>
                        <a-radio value="other">Khác</a-radio>
                    </a-radio-group>
                </div>
            </div>
            <!-- <button class="change-password mb-5">
                Đổi mật khẩu
            </button> -->

            <div class="d-grid gap-3 mb-5" style="grid-template-columns: repeat(2, 1fr);">
                <div class="user-info">
                    <label for="phone" class="fw-bold text-secondary">Số điện thoại</label>
                    <a-input v-model:value="userInfo.phone" size="large" placeholder="Số điện thoại" class="mt-3 " />
                </div>
                <div class="user-info">
                    <label for="address" class="fw-bold text-secondary">Địa chỉ</label>
                    <a-input v-model:value="userInfo.address" size="large" placeholder="Địa chỉ" class="mt-3" />
                </div>
            </div>
            <!-- <a-button type="primary mb-5" size="large">Kết nối Facebook</a-button> -->
            <div class="submit d-flex justify-content-end">
                <button class="cancel me-3">Hủy</button>
                <button class="save" @click="save">Lưu</button>
            </div>
        </div>
    </div>
</template>

<script>
import { CameraOutlined } from '@ant-design/icons-vue';
import axios from 'axios';  // Đảm bảo đã cài axios để thực hiện request
import { getUser } from '../../services/auth';
export default {
    components: {
        CameraOutlined
    },
    data() {
        return {
            userInfo: {
                name: '',
                email: '',
                phone: '',
                address: '',
                avatar: '',
            },
            dob: {
                day: null,
                month: null,
                year: null,
            },
            description: '',
            gender: '',
            avatarUrl: null,
        };
    },
    mounted() {
        this.fetchUserInfo();
    },
    methods: {
        async save() {
            const userBioData = {
                bio_description: this.bioDescription,
                dob: `${this.dob.year}-${this.dob.month}-${this.dob.day}`,
                gender: this.gender,
                phone: this.userInfo.phone,
                address: this.userInfo.address,
                current_job: this.userInfo.current_job,
                education: this.userInfo.education,
                current_location: this.userInfo.current_location,
                hometown: this.userInfo.hometown,
            };

            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/saveUserBio/2`, userBioData);
                console.log('UserBio updated successfully:', response.data);
                if (this.avatarUrl) {
                    const userId = getUser().id;
                    const response = await axios.post(`http://127.0.0.1:8000/api/user/${userId}/update-avatar`, {
                        avatar: this.avatarUrl
                    });
                    console.log("Avatar đã được cập nhật thành công!");
                }

            } catch (error) {
                console.error('Error updating UserBio:', error);
            }



        },

        async handleImageChange(event, type) {
            const file = event.target.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('image', file);
                try {
                    const response = await axios.post('http://127.0.0.1:8000/api/uploadAvatar', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    });

                    const filePath = response.data.filePath;
                    console.log('Đường dẫn tới ảnh:', filePath);
                    this.avatarUrl = filePath;
                    this.$refs[type].style.backgroundImage = `url(${filePath})`;
                    this.$refs[type].style.backgroundColor = "transparent";
                } catch (error) {
                    console.error("Lỗi tải ảnh lên:", error);
                }
            }
        },
        async fetchUserInfo() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/userBio/2');
                const userBio = response.data;
                const user = userBio.user;

                // Cập nhật thông tin người dùng
                this.userInfo.name = user.username;
                this.userInfo.email = user.email;
                this.userInfo.phone = userBio.phone;
                this.userInfo.address = userBio.address;
                this.avatarUrl = user.avatar;
                this.dob.day = userBio.dob ? userBio.dob.split('-')[2] : null;
                this.dob.month = userBio.dob ? userBio.dob.split('-')[1] : null;
                this.dob.year = userBio.dob ? userBio.dob.split('-')[0] : null;
                this.gender = userBio.gender;
                this.description = userBio.bio_description;

                console.log(this.userInfo);
            } catch (error) {
                console.error("Lỗi khi lấy dữ liệu người dùng:", error);
            }
        },

    }
};
</script>


<style>
.cover-upload,
.avatar-upload {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, .5);
    background-size: cover;
    background-position: center;
    text-align: center;
    cursor: pointer;
}

.cover-upload {
    width: 100%;
    height: 11rem;
}

.avatar-upload {
    width: 9rem;
    height: 9rem;
    border-radius: 50%;
}

.large-icon {
    font-size: 3rem;
    color: #d8d8d8;
}

.text-white {
    color: #b2b2b2;
    margin-top: 0.5rem;
}

.cover-upload:hover .large-icon,
.avatar-upload:hover .large-icon {
    font-size: 3.5rem;
}

input[type="file"] {
    display: none;
}

.textarea {
    width: 30rem;
}

.user-info label {
    display: block;
}

.change-password {
    width: 100%;
    padding: 1rem;
    background-color: white;
    border: 0;
    border-radius: 1rem;
    box-shadow: 0 0.25rem 0.375rem rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.change-password:hover {
    background-color: #edf2f7;
}

.submit button {
    padding: 1rem;
    border: 0;
    border-radius: 1rem;
    cursor: pointer;
}

.submit .cancel {
    background-color: white;
}

.submit .cancel:hover {
    background-color: #edf2f7;
}

.submit .save {
    background-color: #ff9549;
    color: white;
}

.submit .save:hover {
    background-color: #ff7919;
}
</style>
