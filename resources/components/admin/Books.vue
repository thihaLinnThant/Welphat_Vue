<template>
  <v-container fluid>
        <v-overlay :value="loading">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
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

          <v-btn text @click="deleteDialog = false; submitDelete();">Yes</v-btn>
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
                  <v-text-field
                    label="Name"
                    requried
                    v-model="$v.fields.edit_name.$model"
                    outlined
                  ></v-text-field>
                  <small class="red--text" v-if="!$v.fields.edit_name.required">Book Name is required.</small>
                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="$v.fields.edit_authors.$model"
                    outlined
                    :items="author_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Authors"
                    required
                  ></v-autocomplete>
                  <small class="red--text" v-if="!$v.fields.edit_authors.required">Author is required.</small>

                </v-col>
                <v-col cols="12">
                  <v-textarea
                    v-model="$v.fields.edit_book_description.$model"
                    required
                    outlined
                    label="Description"
                  ></v-textarea>
                  <small class="red--text" v-if="!$v.fields.edit_book_description.required">Description is required.</small>

                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="$v.fields.edit_book_price.$model"
                    required
                    outlined
                    label="Price"
                    suffix="ks"
                  ></v-text-field>
                  <small class="red--text" v-if="!$v.fields.edit_book_price.required">Price is required.</small>

                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="$v.fields.edit_book_published_date.$model"
                    outlined
                    label="Publish date"
                    placeholder="2020/05/29"
                    requried
                  ></v-text-field>
                  <small class="red--text" v-if="!$v.fields.edit_book_published_date.required">Published date is required.</small>

                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="$v.fields.edit_categories.$model"
                    outlined
                    :items="category_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Categories"
                    required
                  ></v-autocomplete>
                  <small class="red--text" v-if="!$v.fields.edit_categories.required">Category is required.</small>
0 
                </v-col>
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="$v.fields.edit_tags.$model"
                    outlined
                    :items="tag_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Tags"
                    required
                  ></v-autocomplete>
                  <small class="red--text" v-if="!$v.fields.edit_tags.required">Tag is required.</small>

                </v-col>

                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="$v.fields.edit_publisher.$model"
                    :items="publisher_list"
                    item-text="name"
                    item-value="id"
                    outlined
                    label="Publisher"
                    requried
                  ></v-autocomplete>
                  <small class="red--text" v-if="!$v.fields.edit_publisher.required">Publisher is required.</small>

                </v-col>
                
                <v-col cols="12" md="6">
                  <v-autocomplete
                    v-model="$v.fields.edit_suppliers.$model"
                    outlined
                    :items="supplier_list"
                    item-text="name"
                    item-value="id"
                    multiple
                    label="Suppliers"
                    required
                  ></v-autocomplete>
                  <small class="red--text" v-if="!$v.fields.edit_suppliers.required">Supplier is required.</small>

                </v-col>
                <v-col cols="12" md="6">
                  <v-btn @click="toggleImageUpShow">Upload Image</v-btn>
                </v-col>

                <v-card width="200px" height="250px">
                  <v-img class="white--text align-end" height="200px" :src="fields.edit_image"></v-img>
                  <v-card-text>{{ fields.edit_name }}</v-card-text>
                </v-card>
                <small class="text-danger">{{ errors.image }}</small>
                <my-upload
                  field="img"
                  @crop-success="cropSuccess"
                  @crop-upload-success="cropUploadSuccess"
                  @crop-upload-fail="cropUploadFail"
                  langType="en"
                  v-model="imageUp"
                  :width="150"
                  :height="200"
                  url
                  noCircle
                  img-format="png"
                ></my-upload>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <p v-if="validationStatus == 'error'" class="red--text">Complete your information!</p>

            <v-spacer></v-spacer>
            <v-btn text @click="editDialog = false; target_item = ''; previewImage = null">Cancel</v-btn>
            <v-btn color="primary" text type="submit" outlined>Save</v-btn>
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
            <v-btn @click="openUpdateDialog(book)">Edit</v-btn>
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
import CrudHandler from "../../js/CRUDHandler";
import dataListMixin from "../../js/dataListMixin";
import myUpload from "vue-image-crop-upload";
import formValidation from "../../js/formValidation";

export default {
  mixins: [dataListMixin, CrudHandler, formValidation],

  components: {
    "my-upload": myUpload,
  },
  data() {
    return {
      loading: false,
      search: "",
      progress: false,
      editDialog: false,
      validationStatus: "",
      previewImage: null,
      statename: "books",
      deleteDialog: false,
      imageUp: false,
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
    },
  },
  created() {
    console.log(this.$v);
  },
  methods: {
    uploadImage(e) {
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = (e) => {
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
    openUpdateDialog(book) {
      this.editDialog = true;
      this.target_item = book;
      this.fields.edit_name = book.name;
      this.fields.edit_authors = book.authors.map((value) => value.id);
      this.fields.edit_book_description = book.description;
      this.fields.edit_book_price = book.price;
      this.fields.edit_book_published_date = book.published_date;
      this.fields.edit_categories = book.categories.map((value) => value.id);
      this.fields.edit_tags = book.tags.map((value) => value.id);
      this.fields.edit_publisher = book.publisher.id;
      this.fields.edit_suppliers = book.suppliers.map((value) => value.id);
      this.fields.edit_image = book.thumb;
    },
    toggleImageUpShow() {
      this.imageUp = !this.imageUp;
    },
    cropSuccess(imgDataUrl, field) {
      this.fields.image = imgDataUrl;
      console.log(imgDataUrl);
      this.fields.edit_image = imgDataUrl;

      console.log("-------- crop success --------");
    },
    cropUploadSuccess(jsonData, field) {
      console.log("-------- upload success --------");
      console.log(jsonData);
      console.log("field: " + field);
    },
    cropUploadFail(status, field) {
      console.log("-------- upload fail --------");
      console.log(status);
    },
    save() {
      this.$v.$touch();
      this.$v.$invalid
        ? (this.validationStatus = "error")
        : (this.validationStatus = "success");

      if (!this.$v.$invalid) {
        this.submitEdit();
      } else {
        return;
      }
    },
  },
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
