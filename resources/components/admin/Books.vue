<template>
  <v-container fluid>

    <v-snackbar v-model="alert" color="success">
      {{alertMessage}}
      <v-btn text @click="alert = false">Close</v-btn>
    </v-snackbar>
    <v-dialog v-model="deleteDialog" max-width="350" persistent>
      <v-card>
        <v-card-title>Delete Book</v-card-title>
        <v-card-text>Do you want to delete this book?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="deleteDialog = false; target_item = '';" color="primary" outlined>No</v-btn>

          <v-btn
            text
            @click="deleteDialog = false; submitDelete(target_item.id,target_item.name);"
          >Yes</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>



    <v-dialog v-model="editDialog" max-width="1000" persistent>
      <v-form @submit.prevent="save()" ref="form">
        <v-card>
          <v-card-title>
            <span class="headline">Edit Book</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field label="Name" requried v-model="fields.edit_name" :rules="[v => !!v || 'Name is required']" outlined></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="fields.edit_authors"
                    outlined
                    :items="author_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Authors"
                    :rules="[v => v.length > 0 || 'Author is required']"
                    required
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12">
                  <v-textarea
                    v-model="fields.edit_book_description"
                    required
                    outlined
                    label="Description"
                    :rules="[v => v.length > 0 || 'Description is required']"
                  ></v-textarea>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="fields.edit_book_price"
                    required
                    outlined
                    label="Price"
                    suffix="ks"
                    :rules="[v => !!v || 'Price is required']"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="fields.edit_book_published_date"
                    outlined
                    label="Publish date"
                    placeholder="2020/05/29"
                    requried
                    :rules="[v => !!v || 'Date is required']"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="fields.edit_categories"
                    outlined
                    :items="category_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Categories"
                    :rules="[v => v.length > 0 || 'Category is required']"
                    required
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="fields.edit_tags"
                    outlined
                    :items="tag_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Tags"
                    :rules="[v => v.length > 0 || 'Tag is required']"
                    required
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="fields.edit_publisher"
                    :items="publisher_list"
                    item-text="name"
                    item-value="id"
                    outlined
                    label="Publisher"
                    requried
                    :rules="[v => !!v || 'Publisher is required']"
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="fields.edit_suppliers"
                    outlined
                    :items="supplier_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Suppliers"
                    :rules="[v => v.length > 0 || 'Supplier is required']"
                    required
                  ></v-autocomplete>
                </v-col>
                <v-col cols="12" md="6">
                  <input
                    type="file"
                    @change="uploadImage"
                    requried
                    :rules="[v => !!v || 'Date is required']"
                  />
                </v-col>

                <v-card width="250px">
                  <v-img
                    class="white--text align-end"
                    height="200px"
                    v-if="previewImage"
                    :src="previewImage"
                  >
                    <v-card-title>{{ fields.edit_name }}</v-card-title>
                  </v-img>
                  <v-img class="white--text align-end" height="200px" :src="fields.edit_image" v-else>
                    <v-card-title>{{ fields.edit_name }}</v-card-title>
                  </v-img>
                </v-card>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text @click="editDialog = false; target_item = ''; previewImage = null">Cancel</v-btn>
            <v-btn
              color="primary"
              text
              type="submit"
              outlined
            >Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>
    <v-row class="d-flex">
      <h2>Books</h2>
      <v-spacer></v-spacer>
      <v-text-field @keyup="search_book(search)" v-model="search" placeholder="Search by Book Name"></v-text-field>
      <v-spacer></v-spacer>
      <router-link tag="p" to="books/register">
        <v-btn class="ml-5" outlined style="text-decoration:none !important">Create New +</v-btn>
      </router-link>
    </v-row>
    <v-row align="center" justify="center">
      <h3 v-if="search">Search result</h3>
      <v-pagination
        v-else
        v-model="current_page"
        color="#4054b5"
        circle
        :length="total_pages"
        next-icon="mdi-chevron-right"
        prev-icon="mdi-chevron-left"
        total-visible="10"
        @input="change_page($event)"
      ></v-pagination>
      <v-progress-linear v-if="progress" indeterminate color="#4054b5"></v-progress-linear>
    </v-row>
    <v-row>
      <v-col cols="12" md="4" v-for="(book,index) in books" :key="index">
        <v-card max-width="344" class="mx-auto">
          <span>
            <v-img class="white--text align-end" height="200px" :src="book.thumb">
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
            <v-btn
              @click="openEditDialog(book)"
            >Edit</v-btn>
            <v-btn @click="deleteDialog = true; target_item = book">Delete</v-btn>
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
import EditMixin from "../../js/editFrom";
import DeleteMixin from "../../js/deleteForm";
import lastRecordMixin from "../../js/lastRecordmixin";
import dataListMixin from "../../js/dataListMixin";

export default {
  mixins: [dataListMixin,EditMixin,DeleteMixin,lastRecordMixin],
  data() {
    return {
      search: "",
      progress: false,
      editDialog: false,
      fields: {},
      previewImage: null,
      statename: "books",
      deleteDialog : false

    };
  },

  computed: {
    books() {
      return this.$store.state.books;
    },
    total_pages() {
      return this.$store.state.pagination_length;
    },
    current_page() {
      return this.$store.state.pagination_current;
    }
  },
  methods: {
    uploadImage(e) {
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.previewImage = e.target.result;
        this.fields.edit_image = e.target.result;
      };
    },
    change_page(value) {
      this.progress = true;
      axios.get(`/api/admin/books/?page=${value}`).then(({ data }) => {
        this.progress = false;
        this.$store.commit("addData", { route: "books", data });
      });
    },
    search_book(value) {
      if (value == "" || !value) {
        this.change_page(1);
      } else {
        this.progress = true;
        axios.get(`/api/admin/books/search/${value}`).then(({ data }) => {
          this.progress = false;
          this.$store.commit("addData", { route: "books", data });
        });
      }
    },
    openEditDialog(book) {
      this.editDialog = true
      this.target_item = book
      this.fields.edit_name = book.name
      this.fields.edit_authors = book.authors.map(value => value.id)
      this.fields.edit_book_description = book.description
      this.fields.edit_book_price = book.price
      this.fields.edit_book_published_date = book.published_date
      this.fields.edit_categories = book.categories.map(value => value.id)
      this.fields.edit_tags = book.tags.map(value => value.id)
      this.fields.edit_publisher = book.publisher.id
      this.fields.edit_suppliers = book.suppliers.map(value => value.id)
      this.fields.edit_image = book.thumb
    },
    save() {
      this.$refs.form.validate();
      if (
        !this.fields.edit_name ||
        !this.fields.edit_book_description ||
        !this.fields.edit_authors || this.fields.edit_authors.length < 0 ||
        !this.fields.edit_book_price ||
        !this.fields.edit_book_published_date ||
        !this.fields.edit_tags || this.fields.edit_tags.length < 0 ||
        !this.fields.edit_categories || this.fields.edit_categories.length < 0 ||
        !this.fields.edit_publisher ||
        !this.fields.edit_suppliers || !this.fields.edit_suppliers.length < 0
      ) {
        return;
      }
      this.submitEdit(this.target_item.id)
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
