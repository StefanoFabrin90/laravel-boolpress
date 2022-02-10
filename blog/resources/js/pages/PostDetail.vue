<template>
    <section class="container">
        <div v-if="post">
            <h1 class="mb-5">{{ post.title }}</h1>
            <p>{{ post.content }}</p>
        </div>
        <Loader  v-else />
    </section>
</template>

<script>
import axios from 'axios';
import Loader from '../components/Loader';

export default {
    name: 'PostDetail',
    components: {
        Loader,
    },
    data() {
        return {
            post: null,
        }
    },
    created() {
        //console.log('api');
        this.getPostDetail()
    },
    methods: {
        getPostDetail() {
            axios.get(`http://127.0.0.1:8000/api/posts/${this.$route.params.slug}`)
                .then( res => {
                    //console.log(res.data);
                    this.post = res.data;
                })
                .catch(err => log.error(err));
        } 
    }
}
</script>

<style lang="scss" scoped>

</style>