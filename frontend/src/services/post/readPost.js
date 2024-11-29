import { ref, reactive, computed, onMounted, onBeforeUnmount } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getUser, isLoggedIn } from '../auth';
import { notification } from 'ant-design-vue';
import axios from 'axios';


export default function useReadPost() {
    const open = ref(false);
    // Follow
    const isFollowing = ref(false);

    // Scroll
    const showScrollTopButton = ref(false);
    // Vote
    const upVotes = ref(0);
    const downVotes = ref(0);
    const isCaretUpActive = ref(false);
    const isCaretDownActive = ref(false);

    // Sticky bar
    const showStickyBar = ref(false);
    const postContentRef = ref(null);
    const stickyBarObserver = ref(null);

    // Bookmark
    const isBookmarked = ref(false);
    // Route
    const route = useRoute();
    const router = useRouter();
    // Tags
    const tags = ref([]);
    // Post
    const postSlug = route.params.slug;

    const post = ref({});

    const errorMessage = ref('');

    // User
    const author = ref('');

    const userId = isLoggedIn() ? getUser().id : null;

    const showModal = () => {
        open.value = true;
    };
    // Content
    const fetchPostData = () => {
        axios
            .get(`http://127.0.0.1:8000/api/posts/${postSlug}`)
            .then((response) => {
                post.value = response.data;
                getAuthor();
                getTags();
                checkFollow();
            })
            .catch(() => {
                errorMessage.value = 'Lỗi khi tải dữ liệu bài viết.';
            });
    };

    const deletePost = () => {
        axios
            .delete(`http://127.0.0.1:8000/api/delete/${postSlug}`)
            .then(response => {
                notification.success({
                    message: 'Bài viết đã được xóa thành công',
                    duration: 2,
                    style: {
                        backgroundColor: '#f6ffed',
                    }
                });
                router.push('/');
            })
            .catch(error => {
                notification.error({
                    message: 'Lỗi khi xóa bài viết',
                    duration: 2,
                    style: {
                        backgroundColor: '#fff2f0',
                    }
                });
                console.error('Lỗi khi xóa bài viết:', error);
            });
    };
    // Follow
    const followUser = () => {
        const follow = {
            follower: userId,
            following: post.value.users_id
        };

        axios.post('http://127.0.0.1:8000/api/follow', follow)
            .then((response) => {
                if (response.data.message === 'Followed successfully') {
                    isFollowing.value = true; // Cập nhật trạng thái follow
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
    };

    const unfollowUser = () => {
        const follow = {
            follower: userId,
            following: post.value.users_id
        };

        axios.post('http://127.0.0.1:8000/api/unfollow', follow)
            .then((response) => {
                if (response.data.message === 'Unfollowed successfully') {
                    isFollowing.value = false; // Cập nhật trạng thái follow
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
    };

    const checkFollow = () => {
        const follow = {
            follower: userId,
            following: post.value.users_id
        };

        axios.post('http://127.0.0.1:8000/api/checkFollow', follow)
            .then(response => {
                isFollowing.value = response.data.isFollowing; // Cập nhật trạng thái follow
            })
            .catch(error => {
                console.error("Error checking follow status:", error);
            });
    };

    // Scroll
    const handleScroll = () => {
        showScrollTopButton.value = window.scrollY > 100;
        if (postContentRef.value) {
            const rect = postContentRef.value.getBoundingClientRect();

            if (rect.top <= 0 && rect.bottom > window.innerHeight) {
                showStickyBar.value = true;
            } else {
                showStickyBar.value = false;
            }
        }
    };
    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    // bookmark
    const toggleBookmark = () => {
        if (!userId) {
            router.push('/login');
        }
        isBookmarked.value = !isBookmarked.value;
        if (isBookmarked.value) {
            notification.success({
                message: `Lưu bài viết thành công`,
                duration: 2,
                style: {
                    backgroundColor: '#f6ffed',
                }
            });
        } else {
            notification.success({
                message: `Bỏ lưu bài viết thành công`,
                duration: 2,
                style: {
                    backgroundColor: '#f6ffed',
                }
            });
        }

    };

    // Vote
    const handleVote = async (type) => {
        if (!userId) {
            router.push('/login');
            return;
        }
        try {
            const response = await axios.post('http://127.0.0.1:8000/api/votes', {
                vote_type: type,
                post_id: post.value.id,
                user_id: userId,
            });

            console.log(response.data.message);

            if (type === 'up') {
                isCaretUpActive.value = !isCaretUpActive.value;
                if (isCaretUpActive.value) isCaretDownActive.value = false;
            } else {
                isCaretDownActive.value = !isCaretDownActive.value;
                if (isCaretDownActive.value) isCaretUpActive.value = false;
            }


            fetchVotes();
        } catch (error) {
            console.error('Lỗi khi gửi vote:', error);
        }
    };

    const fetchVotes = async () => {
        try {
            const response = await axios.get(`http://127.0.0.1:8000/api/votes/${post.value.id}`);
            upVotes.value = response.data.up_votes;
            downVotes.value = response.data.down_votes;
        } catch (error) {
            console.error('Lỗi khi tải số vote:', error);
        }
    };

    const toggleCaret = (direction) => {
        if (direction === 'up') {
            isCaretUpActive.value = !isCaretUpActive.value;
            if (isCaretUpActive.value) isCaretDownActive.value = false;
        } else if (direction === 'down') {
            isCaretDownActive.value = !isCaretDownActive.value;
            if (isCaretDownActive.value) isCaretUpActive.value = false;
        }
    };
    fetchVotes();


    const renderedContent = computed(() => {
        try {
            const contentArray = JSON.parse(post.value.content || '[]');
            return contentArray
                .map((item) => {
                    if (typeof item === 'object' && item.src) {
                        return `
                            <figure>
                                <img src="${item.src}" alt="${item.caption || ''}" style="max-width: 100%; height: auto;" />
                                ${item.caption ? `<figcaption>${item.caption}</figcaption>` : ''}
                            </figure>
                        `;
                    } else {
                        return item;
                    }
                })
                .join('');
        } catch (error) {
            return 'Nội dung không hợp lệ';
        }
    });
    // 
    const getAuthor = () => {
        axios
            .get(`http://127.0.0.1:8000/api/users/${post.value.users_id}`)
            .then((response) => {
                author.value = response.data;
            })
            .catch(() => {
                errorMessage.value = 'Lỗi khi lấy tên người dùng.';
            });
    };
    const getTags = () => {
        axios
            .get(`http://127.0.0.1:8000/api/tags/${post.value.tags_id}`)
            .then((response) => {
                tags.value = response.data;
            })
            .catch(() => {
                errorMessage.value = 'Lỗi khi lấy tên người dùng.';
            });
    };

    // Sticky bar
    const observeStickyBar = () => {
        if (postContentRef.value) {
            stickyBarObserver.value = new IntersectionObserver(
                ([entry]) => {
                    showStickyBar.value = entry.isIntersecting;
                },
                {
                    root: null,
                    threshold: 0,
                }
            );

            stickyBarObserver.value.observe(postContentRef.value);
        }
    };

    // Date
    const formattedDate = computed(() => {
        if (post.value.created_at) {
            const currentYear = new Date().getFullYear();
            const date = new Date(post.value.created_at);
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            if (currentYear !== year) {
                return `${day} tháng ${month} năm ${year}`;
            }

            return `${day} tháng ${month}`;
        }
        return '';
    });


    onMounted(() => {
        fetchPostData();
        observeStickyBar();
        window.addEventListener('scroll', handleScroll);

    });
    onBeforeUnmount(() => {
        window.removeEventListener('scroll', handleScroll);
        if (stickyBarObserver.value) {
            stickyBarObserver.value.disconnect();
        }
    });

    return {
        open,
        showModal,
        // Post
        post,
        author,
        userId,
        // Tags
        tags,
        errorMessage,
        // Content
        renderedContent,
        postContentRef,
        // Date
        formattedDate,
        // sticky bar
        showStickyBar,
        // Vote
        toggleCaret,
        upVotes,
        downVotes,
        isCaretUpActive,
        isCaretDownActive,
        handleVote,
        // Bookmark
        isBookmarked,
        toggleBookmark,
        // Scroll
        showScrollTopButton,
        scrollToTop,
        // Follow
        isFollowing,
        followUser,
        unfollowUser,
        // delete
        deletePost
    };
}
