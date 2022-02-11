<template>
    <div class="application">
        <!-- header -->
        <Header />

        <!-- main -->
        <main>
            <router-view></router-view>
        </main>

        <!-- footer -->
        <Footer />
    </div>
</template>

<script>
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'

export default {
    name: 'App',
    components: {
        Header,
        Footer,
    },
}
</script>

<style lang="scss">
    .application {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        main {
            flex: 1;
        }
    }
</style>