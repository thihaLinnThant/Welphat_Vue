<template>
  <div>
        <div class="ml-5 d-flex">
            <h2>Authors</h2>
            <router-link tag="p" to="authors/register">
                <v-btn class="ml-5" outlined >Create New +</v-btn>
            </router-link>
        </div>
        <v-row align="center" justify="center">
                <v-card width="200px" class="ma-3" v-for="author in authors" :key=author.id>
                    <v-img
                    class="white--text align-end"
                    height="200px"                
                    :src=author.thumb
                    ></v-img>
                    <v-card-text>{{ author.name }}<br>books: {{author.count}}</v-card-text>
                    <v-card-actions>
                        <v-btn>Edit</v-btn>
                        <v-btn>Delete</v-btn>
                    </v-card-actions>
                </v-card>          
        </v-row>
  </div>
</template>

<script>
export default {
    computed: {
        authors() {
            return this.$store.state.authors;
        }
    }
}
</script>

<style>

</style>