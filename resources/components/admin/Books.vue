<template>
    <v-row justify="start" class="ml-1 mr-0">        
        <v-card class="ma-2 book-card" width="250px" v-for="book in books" :key=book.id>
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
                    <div v-for="author in book.authors" :key=author.id>
                        <p class="mb-0" >&nbsp;&nbsp; {{ author.name }},</p>
                    </div>
                </div>
            </v-card-subtitle>

            <v-card-text >
                <p class="mb-0"><b>Categories:</b></p>
                <div class="d-flex">
                    &nbsp;&nbsp; <div class="cust-badge" v-for="category in book.categories" :key=category.id><a href="#">{{category.name}}</a></div>
                </div>
                
                <p class="mb-0 mt-1"><b>Tags:</b></p>                    
                    <v-chip-group
                        dense
                        active-class="primary--text"
                    >
                        <v-chip small v-for="tag in book.tags" :key=tag.id>
                        {{ tag.name }}
                        </v-chip>
                    </v-chip-group>                                    
            </v-card-text>
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