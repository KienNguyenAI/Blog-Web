<template>
    <div>
        <div class="container ">
            <h2 class="top-blog-heading"># TOP 10 BÀI VIẾT NỔI BẬT</h2>
        </div>

        <Post />
        <Post />
    </div>
</template>
<script>
import Post from '../../components/cards/Post.vue';
export default {
    components: {
        Post
    }
}
</script>
<style>
.top-blog-heading {
    text-align: left;
    font-size: 2.5rem;
    padding: 1rem;
    margin-right: 15.5rem;
    margin-left: 15.5rem;
    border-bottom: 1px solid #e8e8e8;
}

@media (max-width: 768px) {
    .top-blog-heading {
        margin: 0;
        font-size: 1rem;
        margin-top: 2rem;
    }
}
</style>