<template>
  <v-form class="ma-10">
    <h2>Book Register</h2>
    <v-row justify="center">
      <v-col cols="12" md="6">
        <v-text-field v-model="book_name" outlined label="Name"></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-autocomplete :error="goterror" :error-messages="errors.authors" v-model="fields.authors" outlined :items="author_list" item-text="name" multiple label="Author(s)"></v-autocomplete>
      </v-col>
      <v-col cols="12" md="6">
        <v-autocomplete :error="goterror" :error-messages="errors.categories" v-model="fields.categories" outlined :items="categories" item-text="name" multiple label="Categories"></v-autocomplete>
      </v-col>
      <v-col cols="12" md="6">
        <v-autocomplete :error="goterror" :error-messages="errors.tags" v-model="fields.tags" :items="tag_list" item-text="name" outlined multiple label="Tags"></v-autocomplete>
      </v-col>
      <v-col cols="12" md="6">
        <v-autocomplete :error="goterror" :error-messages="errors.publishers" v-model="fields.publishers" :items="publisher_list" item-text="name" outlined label="Publisher"></v-autocomplete>
      </v-col>
      <v-col cols="12" md="6">
        <v-file-input :error="goterror" :error-messages="errors.image" v-model="fields.image" @change="Preview_image($event)" outlined label="Upload Image"></v-file-input> 
      </v-col>

      <v-card width="250px">
        <v-img class="white--text align-end" height="200px" :src="image_url">
          <v-card-title>{{ book_name }}</v-card-title>
        </v-img>
      </v-card>
    </v-row>
  </v-form>
</template>

<script>
import RecordInput from '../../js/RecordInputmixin';
export default {
  data() {
    return {
      book_name: null,
      image_url: "https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQ3mlqedKcDFuzWNP0CybnRWz8H9TTZVw8d5yUjf1dclZrJX53g&usqp=CAU"
    };
  },
  computed: {
    categories() {
      return this.$store.state.categories;
    },
    authors(){
        return this.$store.state.authors;
    },
    tags(){
        return this.$store.state.tags;
    },
    publishers(){
        return this.$store.state.publishers;
    },
    category_list() {
      let categoryTemp = [];
      this.categories.forEach(element => {
        categoryTemp.push({name : element.name, id: element.id});
      });
      return categoryTemp;
    },
    author_list(){
        let authorTemp = [];
        this.authors.forEach(element => {
            authorTemp.push({name : element.name, id: element.id});
        });
        return authorTemp
    },
    tag_list(){
        let tagTemp = [];
        this.tags.forEach(element => {
            tagTemp.push({name : element.name, id: element.id});
        });
        return tagTemp
    },
    publisher_list(){
        let publisherTemp = [];
        this.publishers.forEach(element => {
            publisherTemp.push({name : element.name, id: element.id});
        })
        return publisherTemp
    }

  },
  methods: {
    Preview_image(e) {
      this.image_url = URL.createObjectURL(e);
    }
  }
};
</script>

<style>
</style>
