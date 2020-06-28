<template>
  <v-form class="ma-10" @submit.prevent="submit" enctype="multipart/form-data">
    <h2>Book Register</h2>
    <v-row justify="center">
      <v-col cols="12" md="6">
        <v-text-field v-model="fields.book_name" outlined label="Name"></v-text-field>
      </v-col>

      <v-col cols="12" md="6">
        <v-autocomplete
          v-model="fields.authors"
          outlined
          :items="author_list"
          item-text="name"
          multiple
          label="Author(s)"
        ></v-autocomplete>
      </v-col>
      <v-col cols="12" md="12">
        <v-textarea v-model="fields.book_description" outlined label="Description"></v-textarea>
      </v-col>
      <v-col cols="12" md="6">
        <v-text-field v-model="fields.book_price" outlined label="Price" suffix="ks"></v-text-field>
      </v-col>
      <v-col cols="12" md="6">
        <v-text-field
          v-model="fields.book_published_date"
          outlined
          label="Publish date"
          placeholder="2020/05/29"
        ></v-text-field>
      </v-col>

      <v-col cols="12" md="6">
        <v-autocomplete
          v-model="fields.categories"
          outlined
          :items="categories"
          item-text="name"
          multiple
          label="Categories"
        ></v-autocomplete>
      </v-col>
      <v-col cols="12" md="6">
        <v-autocomplete
          v-model="fields.tags"
          :items="tag_list"
          item-text="name"
          outlined
          multiple
          label="Tags"
        ></v-autocomplete>
      </v-col>
      <v-col cols="12" md="6">
        <v-autocomplete
          v-model="fields.publisher"
          :items="publisher_list"
          item-text="name"
          item-value="id"
          outlined
          label="Publisher"
        ></v-autocomplete>
      </v-col>
      <v-col cols="12" md="6">
        <v-autocomplete
          v-model="fields.supplier"
          :items="supplier_list"
          item-text="name"
          outlined
          label="Supplier"
        ></v-autocomplete>
      </v-col>

      <v-col cols="12" md="6">
        <v-file-input
          v-model="fields.image"
          @change="Preview_image($event)"
          outlined
          label="Upload Image"
        ></v-file-input>
      </v-col>

      <v-card width="250px">
        <v-img class="white--text align-end" height="200px" :src="image_url">
          <v-card-title>{{ fields.book_name }}</v-card-title>s
        </v-img>
      </v-card>
    </v-row>
    <v-btn color="success" @click.prevent="save" type="submit">Create</v-btn>
  </v-form>
</template>

<script>
import { mapState } from "vuex";
import RecordInput from "../../js/RecordInputmixin";
export default {
  data() {
    return {
      fields: {},
      image_url:
        "https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQ3mlqedKcDFuzWNP0CybnRWz8H9TTZVw8d5yUjf1dclZrJX53g&usqp=CAU",
      act: "/admin/books/create",
      statename: "authors"
    };
  },
  mixins: [RecordInput],
  computed: mapState({
    categories: "categories",
    authors: "authors",
    tags: "tags",
    publishers: "publishers",
    suppliers: "suppliers",
    category_list() {
      let categoryTemp = [];
      this.categories.forEach(element => {
        categoryTemp.push({ name: element.name, id: element.id });
      });
      return categoryTemp;
    },
    author_list() {
      let authorTemp = [];
      this.authors.forEach(element => {
        authorTemp.push({ name: element.name, id: element.id });
      });
      return authorTemp;
    },
    tag_list() {
      let tagTemp = [];
      this.tags.forEach(element => {
        tagTemp.push({ name: element.name, id: element.id });
      });
      return tagTemp;
    },
    publisher_list() {
      let publisherTemp = [];
      this.publishers.forEach(element => {
        publisherTemp.push({ name: element.name, id: element.id });
      });
      return publisherTemp;
    },
    supplier_list() {
      let supplierTemp = [];
      this.suppliers.forEach(element => {
        supplierTemp.push({ name: element.name, id: element.id });
      });
      return supplierTemp;
    }
  }),

  methods: {
    Preview_image(e) {
      this.image_url = URL.createObjectURL(e);
    },
    save() {
      console.log(this.fields);
      this.submit();
    }
  }
};
</script>

<style>
</style>
