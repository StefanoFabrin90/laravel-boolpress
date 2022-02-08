<template>
  <div>
      <div class="container text-center mt-5">
        <h1 class="mb-5">our Blog</h1>
        <div v-if="posts">
            <article v-for="post in posts" :key="`post-${post.id}`">
                <h2 class="mb-3">{{post.title}}</h2>
                <p>{{ post.created_at }}</p>
                <p>{{ post.content }}</p>
                <hr>
            </article>
        </div>
        <div v-else>
            <p class="text-center">Loading......</p>
        </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'App',
    component:{},
    data() {
        return {
            posts: null,
        }
    },
    created() {
        this.getPosts();
    },
    methods: {
        getPosts() {
            //console.log('axios');
            axios.get('http://127.0.0.1:8000/api/posts')
                .then(response => {
                    this.posts = response.data
                });
        }
    }
}
</script>

<style lang="scss">
    .container {
        h1 {
            text-transform: uppercase;
            color: red;
        }
    }
</style>