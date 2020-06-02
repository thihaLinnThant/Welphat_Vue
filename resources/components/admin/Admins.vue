<template>
    <div>
        <p>{{admins}}</p>
    </div>
</template>


<script>
export default {
    computed:{
        admins(){
            return this.$store.state.admins;
        }
    }
}
</script>
