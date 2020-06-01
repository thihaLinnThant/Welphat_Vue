<template>
    <div>
        <div class="ml-5 d-flex">
            <h2>Books</h2>
            <router-link tag="p" to="books/register">
                <v-btn class="ml-5" outlined style="text-decoration:none !important">Create New +</v-btn>
            </router-link>
        </div>
        <v-row justify="start" class="ml-1 mr-0">
            <v-card class="ma-2 book-card" width="250px" v-for="(book,index) in books" :key="index">
                <v-img
                    class="white--text align-end"
                    height="200px"
                    :src=book.thumb
                >
                    <v-card-title>{{ book.name }}</v-card-title>
                </v-img>

                <v-card-actions align="center">
                    <v-btn>View</v-btn>
                    <v-btn>Edit</v-btn>
                    <v-btn>Delete</v-btn>
                </v-card-actions>

                <v-card-subtitle class="pb-1 pt-1">
                    <p class="mb-0"><b>Authors:</b></p>
                    <div class="d-inline-flex">
                        <div v-for="(author,index) in book.authors" :key="index">
                            <p class="mb-0" >&nbsp;&nbsp; {{ author.name }},</p>
                        </div>
                    </div>
                </v-card-subtitle>

                <v-card-text >
                    <p class="mb-0"><b>Categories:</b></p>
                    <v-chip color="#4054b5" class="ma-1" small v-for="(category,index) in book.categories" :key="index">
                        {{ category.name }}
                    </v-chip>

                    <p class="mb-0 mt-1"><b>Tags:</b></p>
                    <v-chip color="#4054b5" class="ma-1" small v-for="(tag,index) in book.tags" :key="index">
                        {{ tag.name }}
                    </v-chip>
                </v-card-text>
            </v-card>
        </v-row>
    </div>

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
router
.cust-badge {
    min-width: 40px;
    text-align: center;
    border-radius: 30px;
    padding: 0px 8px;
    background-color: #4054b5;
    margin-right: 5px;
    transition: ease-in-out 0.1s;
}
.cust-badge > a {
    color: white !important;
    text-decoration: none;
    overflow: initial;
}
.cust-badge:hover {
    background: blueviolet;
}
</style>
