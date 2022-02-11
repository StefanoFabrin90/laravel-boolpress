<template>
    <section class="container">
        <div v-if="post">
            <h1 class="mb-5">{{ post.title }}</h1>
            <p>{{ post.content }}</p>

            <!-- category -->
            <p> <strong>CATEGORY</strong>: {{ post.category.name }}</p>
        
            <!-- tag -->
            <div class="mb-5">
                <span class="badge badge-success mr-3" v-for="tag in post.tags" :key="`tag-${tag.id}`">
                    {{ tag.name }}
                </span>
            </div>
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
        },
    }
}
</script>

<style lang="scss" scoped>

</style>