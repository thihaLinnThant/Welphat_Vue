<template>
  <v-container fluid>
    <v-row class="d-flex">
      <h2>Books</h2>
      <v-spacer></v-spacer>
      <v-text-field v-model="search" placeholder="Search by Book Name"></v-text-field>
      <v-spacer></v-spacer>
      <router-link tag="p" to="books/register">
        <v-btn class="ml-5" outlined style="text-decoration:none !important">Create New +</v-btn>
      </router-link>
    </v-row>
    <v-row align="center" justify="end">
      <v-pagination
        v-model="current_page"
        color="#4054b5"
        circle
        :length=total_pages
        next-icon="mdi-chevron-right"
        prev-icon="mdi-chevron-left"
        total-visible=10
        @input="change_page($event)"
      ></v-pagination>
    </v-row>
    <v-row>
      <v-col cols="12" md="4" v-for="(book,index) in books" :key="index">
        <v-card max-width="344" class="mx-auto">
          <span>
            <v-img
              class="white--text align-end"
              height="200px"
              :src="book.thumb"
            >
              <v-card-title class="justify-center">{{ book.name }}</v-card-title>
            </v-img>
          </span>

          <div v-for="(author,index) in book.authors" :key="index" class="justify-center">
            <p class="mb-0" style="color: grey;text-align:center">{{ author.name }}</p>
          </div>

          <v-card-actions class="justify-center">
            <router-link :to="'/admin/books/'+book.id" style="text-decoration:none">
            <v-btn>View</v-btn>
            </router-link>
            <v-btn>Edit</v-btn>
            <v-btn>Delete</v-btn>
          </v-card-actions>

          <v-card-text>
            <span class="d-flex">
              <p class="mb-0">
                <b>Categories</b>
              </p>
              <v-spacer></v-spacer>
              <v-chip
                color="#4054b5"
                class="ma-1"
                small
                v-for="(category,index) in book.categories"
                :key="index"
              >{{ category.name }}</v-chip>
            </span>
            <span class="d-flex">
              <p class="mb-0 mt-1">
                <b>Tags</b>
              </p>
              <v-spacer></v-spacer>
              <v-chip
                color="#4054b5"
                class="ma-1"
                small
                v-for="(tag,index) in book.tags"
                :key="index"
              >{{ tag.name }}</v-chip>
            </span>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data(){
    return {
      search : ''
    }
  },
  computed: {
    books() {
      return this.$store.state.books.filter(element => {
        return element.name.toLowerCase().includes(this.search.toLowerCase())
      })
    },
    total_pages() {
      return this.$store.state.pagination_length;
    },
    current_page() {
      return this.$store.state.pagination_current;
    }
  },
  methods: {
    change_page(value) {
      axios.get(`/api/admin/books/?page=${value}`).then(({data}) => {
        this.$store.commit('addData', { route: 'books', data})
      });
    }
  }
};
</script>

<style>
router .cust-badge {
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
