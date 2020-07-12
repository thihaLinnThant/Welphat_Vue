<template>
    <div>
        <p>{{overview}}</p>
    </div>
</template>

<script>
export default {
    computed:{
        overview(){
            return this.$store.state.overview
        }
    }
}
</script>

<style lang="css" scoped>
</style>
