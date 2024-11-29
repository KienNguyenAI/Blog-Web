
import { notification } from 'ant-design-vue';
export function follow(userId, followingId) {
    const follow = {
        follower: userId,
        following: followingId
    };

    axios.post('http://127.0.0.1:8000/api/follow', follow)
        .then((response) => {
            if (response.data.message === 'Followed successfully') {
                notification.success({
                    message: `Đã theo dõi người viết`,
                    duration: 1,
                    style: {
                        backgroundColor: '#f6ffed',
                    }
                });
                return true;
            }
        })
        .catch((error) => {
            console.error('Lỗi khi thực hiện follow:', error);
        });
}
export function unfollow(userId, followingId) {

    const follow = {
        follower: userId,
        following: followingId
    };
    axios.post('http://127.0.0.1:8000/api/unfollow', follow)
        .then((response) => {
            if (response.data.message === 'Unfollowed successfully') {
                notification.success({
                    message: `Đã hủy theo dõi người viết`,
                    duration: 1,
                    style: {
                        backgroundColor: '#f6ffed',
                    }
                });
                return false;
            }
        })
        .catch((error) => {
            console.error('Lỗi khi thực hiện unfollow:', error);
        });
}
export async function checkFollow(userId, followingId) {


    const follow = {
        follower: userId,
        following: followingId
    };

    try {
        const response = await axios.post('http://127.0.0.1:8000/api/checkFollow', follow);
        return response.data.isFollowing;
    } catch (error) {
        console.error("Error checking follow status:", error);
        return false;
    }

}
const getFollowedAuthors = async () => {
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/getFollowedAuthors', {
            follower: userId
        });
        console.log("Followed authors:", response.data.followedAuthors);
    } catch (error) {
        console.error('Error fetching followed authors:', error);
    }
};
