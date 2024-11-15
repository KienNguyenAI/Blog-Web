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
                    <a-textarea :rows="4" :maxlength="150" show-count style="height: 100%;" />
                </div>
            </div>
            <div class="d-grid gap-3 mb-5" style="grid-template-columns: repeat(2, 1fr);">
                <div class="user-info">
                    <label for="name" class="fw-bold text-secondary">Tên người dùng</label>
                    <a-input v-model:value="value" size="large" placeholder="large size" class="mt-3 " />
                </div>
                <div class="user-info">
                    <label for="email" class="fw-bold text-secondary">Email</label>
                    <a-input v-model:value="value" size="large" placeholder="large size" class="mt-3" />
                </div>
                <div class="user-info">
                    <label for="dob" class="fw-bold text-secondary">Ngày sinh</label>
                    <div class="d-flex mt-3">
                        <a-select v-model:value="day" class="me-2" placeholder="Ngày" size="large" style="flex: 1;">
                            <a-select-option v-for="n in 31" :key="n" :value="n">{{ n }}</a-select-option>
                        </a-select>
                        <a-select v-model:value="month" class="me-2" placeholder="Tháng" size="large" style="flex: 1;">
                            <a-select-option v-for="n in 12" :key="n" :value="n">{{ n }}</a-select-option>
                        </a-select>
                        <a-select v-model:value="year" class="me-2" placeholder="Năm" size="large" style="flex: 1;">
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
            <button class="change-password mb-5">
                Đổi mật khẩu
            </button>

            <div class="d-grid gap-3 mb-5" style="grid-template-columns: repeat(2, 1fr);">
                <div class="user-info">
                    <label for="phone" class="fw-bold text-secondary">Số điện thoại</label>
                    <a-input v-model:value="value" size="large" placeholder="large size" class="mt-3 " />
                </div>
                <div class="user-info">
                    <label for="address" class="fw-bold text-secondary">Địa chỉ</label>
                    <a-input v-model:value="value" size="large" placeholder="large size" class="mt-3" />
                </div>
            </div>
            <a-button type="primary mb-5" size="large">Kết nối Facebook</a-button>
            <div class="submit d-flex justify-content-end">
                <button class="cancel me-3">Hủy</button>
                <button class="save">Lưu</button>
            </div>
        </div>
    </div>
</template>

<script>
import { CameraOutlined } from '@ant-design/icons-vue';

export default {
    components: {
        CameraOutlined
    },
    methods: {
        handleImageChange(event, type) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.$refs[type].style.backgroundImage = `url(${e.target.result})`;
                    this.$refs[type].style.backgroundColor = "transparent"; // Đổi màu nền khi có ảnh
                };
                reader.readAsDataURL(file);
            }
        }
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
    background-color: #4096ff;
    color: white;
}

.submit .save:hover {
    background-color: #3182ce;
}
</style>
