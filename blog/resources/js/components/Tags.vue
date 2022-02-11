<template>
    <!-- tag -->
        <div>
            <span 
                class="badge badge-success mr-3" 
                v-for="tag in list" :key="`tag-${tag.id}`"
            >
                {{ tag.name }}
            </span>
        </div>
</template>

<script>
export default {
    name: 'Tags',
    props: {
        list: Array
    }
}
</script>

<style lang="scss" scoped>

</style>