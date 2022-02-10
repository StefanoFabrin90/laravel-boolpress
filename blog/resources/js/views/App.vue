<template>
  <div>
      <div class="container mt-5 mb-5">
        <h1 class="mb-5 text-center">our Blog</h1>
        <div v-if="posts">
            <article class="card my-3 p-3" v-for="post in posts" :key="`post-${post.id}`">
                <h2 class="mb-3">{{post.title}}</h2>
                <ul>
                    <li>{{ formatDate(post.created_at) }}</li>
                    <li>{{ getExcerpt(post.content, 150) }}</li>
                </ul>
            </article>

            <!-- paginazione -->
            <div class="d-flex justify-content-center">
                <button 
                class="btn btn-success mr-3"
                :disabled="pagination.current === 1 "
                @click="getPosts(pagination.current - 1)"
                >
                    Prev
                </button>

                <!-- numeri -->
                <button
                    v-for="i in pagination.last" :key="`page-${i}`"
                    @click="getPosts(i)"
                    class="btn mr-3"
                    :class="pagination.current === i ? 'btn-success' : 'btn-light'"
                >
                    {{ i }}
                </button>

                <button
                    class="btn btn-success"
                    :disabled="pagination.current === pagination.last "
                    @click="getPosts(pagination.current + 1)"
                >
                    Next
                </button>
            </div>
            
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
            pagination: null,
        }
    },
    created() {
        this.getPosts();
    },
    methods: {
        getPosts(page = 1) {
            //console.log('axios');
            axios.get(`http://127.0.0.1:8000/api/posts?page=${page}`)
                .then(response => {
                    console.log(response);
                    // this.posts = response.data // A) senza paginazione
                    this.posts = response.data.data // B) con paginazione
                    this.pagination = {
                        current: response.data.current_page,
                        last: response.data.last_page
                    }
                });
        },
        getExcerpt(text, maxLength) {
            if(text.length > maxLength) {
                return text.substr(0, maxLength) + '...';
            }
            return text;
        },
        formatDate(postDate) {
            const date = new Date(postDate); //convertire la stringa in oggetto js valido

            const formatted = new Intl.DateTimeFormat('it-IT').format(date);

            return formatted;
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