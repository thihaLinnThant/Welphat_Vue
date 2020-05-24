<template>
    <v-row>
        <v-card v-for="(book, i) in books" :key=i>
            <v-image
            class="white--text align-end"
            height="200px"
            :src=book.thumb
        >
            <v-title>{{ book.name }}</v-title>
        </v-image>

        <v-card-subtitle v-for="(author, i) in book.authors" :key=i>{{ book.author.name }}</v-card-subtitle>
        <v-card-text>
            <div v-for="(category, i) in book.categories" :key=i>
                <v-badge>{{ category.name }}</v-badge>
            </div>
            <div v-for="(tag, i) in book.tags" :key=i>
                <v-badge>{{ tag.name }}</v-badge>
            </div>
        </v-card-text>

        <v-card-actions>
            <v-btn>View</v-btn>
            <v-btn>Edit</v-btn>
            <v-btn>Delete</v-btn>
        </v-card-actions>
        </v-card>        
    </v-row>
</template>

<script>
export default {
    computed: {
        books() {
            return this.$store.state.books;
        }
    }
}
</script>

<style>

</style>