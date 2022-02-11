<template>
    <section class="container">
        <div v-if="post">
            <h1 class="mb-5">{{ post.title }}</h1>
            <p>{{ post.content }}</p>

            <!-- category -->
            <p> <strong>CATEGORY</strong>: {{ post.category.name }}</p>
        
            <!-- tag -->
            <Tags class="mb-5" :list="post.tags" />
        </div>

        <Loader  v-else />
    </section>
</template>

<script>
import axios from 'axios';
import Loader from '../components/Loader';
import Tags from '../components/Tags';

export default {
    name: 'PostDetail',
    components: {
        Loader,
        Tags,
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
                    console.log(res.data);
                    this.post = res.data;
                })
                .catch(err => log.error(err));
        },
    }
}
</script>

<style lang="scss" scoped>

</style>