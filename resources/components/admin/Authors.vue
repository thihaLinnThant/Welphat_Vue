<template>
  <v-container fluid>
    <!-- add new dialog -->
    <v-row justify="center">
      <v-dialog v-model="addNew_Dialog" persistent max-width="600px">
        <v-form @submit.prevent="submit" enctype="multipart/form-data">
          <v-card>
            <v-card-title>
              <span class="headline">Add Author</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12">
                    <v-text-field
                      :error="errors.name"
                      :error-messages="errors.name"
                      v-model="fields.name"
                      name="name"
                      outlined
                      label="Name"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-textarea
                      :error="errors.bio"
                      :error-messages="errors.bio"
                      v-model="fields.bio"
                      name="bio"
                      label="Bio"
                      outlined
                    ></v-textarea>
                  </v-col>
                  <v-col cols="6" sm="6">
                    <v-btn @click="toggleShow">Upload Image</v-btn>
                  </v-col>
                  <v-col cols="6" sm="6">
                    <v-card width="200px" height="250px">
                      <v-img class="white--text align-end" height="200px" :src="fields.image"></v-img>
                      <v-card-text>{{ fields.name }}</v-card-text>
                    </v-card>
                    <small class="text-danger">{{ errors.image }}</small>
                    <my-upload
                      field="img"
                      @crop-success="cropSuccess"
                      @crop-upload-success="cropUploadSuccess"
                      @crop-upload-fail="cropUploadFail"
                      langType="en"
                      v-model="show"
                      :width="300"
                      :height="300"
                      url
                      img-format="png"
                    ></my-upload>
                  </v-col>

                  <v-btn @click="reset" outlined color="error">reset</v-btn>
                </v-row>
              </v-container>
              <small>*indicates required field</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Close</v-btn>
              <v-btn color="blue darken-1" text @click.prevent="save" type="submit">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>
    </v-row>
    <!-- <v-col cols="12" md="3" v-for="author in authors" :key="author.id"> -->
    <v-dialog v-model="deleteDialog" max-width="350" persistent>
      <v-card>
        <v-card-title>Delete Author</v-card-title>
        <v-card-text>Do you want to delete this category?</v-card-text>
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

    <v-dialog v-model="editDialog" max-width="650" persistent>
      <v-card>
        <v-card-title>
          <span class="headline">Edit Author</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  label="Name*"
                  :error-messages="errors.name"
                  required
                  name="name"
                  v-model="fields.edit_name"
                  outlined
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  name="bio"
                  label="Bio*"
                  :error-messages="errors.bio"
                  required
                  v-model="fields.edit_bio"
                  outlined
                ></v-textarea>
              </v-col>
              <v-col cols="6" sm="6">
                <v-btn @click="toggleShow">Upload Image</v-btn>
              </v-col>
              <v-col cols="6" sm="6">
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
                  v-model="show"
                  :width="300"
                  :height="300"
                  url
                  img-format="png"
                ></my-upload>
              </v-col>
              <small>*indicates required field</small>
              <v-btn @click="reset" outlined color="error">reset</v-btn>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="editDialog = false; target_item = '';">Cancel</v-btn>
          <v-btn
            color="primary"
            text
            @click="submitEdit(target_item.id)"
            type="submit"
            outlined
          >Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card>
      <v-card-title>
        Authors
        <v-spacer></v-spacer>
        <v-btn outlined @click="addNew_Dialog = true">Create New +</v-btn>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table :headers="headers" :items="authors" :search="search">
        <template v-slot:body="{ items }">
          <tbody v-for="(author,index) in items" :key="index">
            <tr>
              <td>{{author.id}}</td>
              <td v-if="author.thumb">
                <v-avatar size="36">
                  <img :src="author.thumb" alt="image" />
                </v-avatar>
              </td>
              <td v-else>
                <v-avatar size="36">
                  <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSnIUIg8ZovaJTxegrtf0tlG2e68gEPDzqmoEjhRWsOzfS1d2FV&usqp=CAU"
                    alt="John"
                  />
                </v-avatar>
              </td>
              <td>{{author.name}}</td>
              <td>{{sliceWord(author.bio,300,'...')}}</td>
              <td>
                <row class="d-flex" justify="space-between">
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn
                        class="mt-1"
                        text
                        icon
                        v-on="on"
                        @click="editDialog = true; target_item = author; fields.edit_name = author.name;
                      fields.edit_bio = author.bio;fields.edit_image = author.thumb"
                      >
                        <v-icon>mdi-pencil</v-icon>
                      </v-btn>
                    </template>
                    <span>edit</span>
                  </v-tooltip>

                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn
                        class="mt-1"
                        text
                        icon
                        v-on="on"
                        @click="deleteDialog = true; target_item = author"
                      >
                        <v-icon>mdi-delete</v-icon>
                      </v-btn>
                    </template>
                    <span>Delete</span>
                  </v-tooltip>
                  <router-link :to="'/admin/authors/'+author.id" style="text-decoration:none">
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <v-btn class="mt-1" text icon v-on="on">
                          <v-icon>mdi-eye</v-icon>
                        </v-btn>
                      </template>
                      <span>View</span>
                    </v-tooltip>
                  </router-link>
                </row>
              </td>
            </tr>
          </tbody>
        </template>
      </v-data-table>
    </v-card>

    <v-snackbar v-model="alert" color="success">
      {{alertMessage}}
      <v-btn text @click="alert = false">Close</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
import InputMixin from "../../js/RecordInputmixin";
import EditMixin from "../../js/editFrom";
import DeleteMixin from "../../js/deleteForm";
import lastRecordMixin from "../../js/lastRecordmixin";
import myUpload from "vue-image-crop-upload";

export default {
  components: {
    // I got the cropper from here "https://vuejsexamples.com/a-beautiful-vue-component-for-image-cropping-and-uploading/"
    "my-upload": myUpload
  },
  mixins: [InputMixin, lastRecordMixin, EditMixin, DeleteMixin],
  data() {
    return {
      search: "",
      addNew_Dialog: false,
      deleteDialog: false,
      editDialog: false,
      act: "/admin/authors/register",
      image_file: null,
      image_url: " ",
      show: false,
      statename: "authors",
      headers: [
        {
          text: "Id",
          align: "start",
          value: "id"
        },
        { text: "Profile", value: "profile_image" },
        { text: "Author Name", value: "name" },
        { text: "Bio", value: "bio" },
        { text: "Actions", value: "actions" }
      ]
    };
  },

  methods: {
    sliceWord(text, length, clamp) {
      clamp = clamp || "...";
      var node = document.createElement("div");
      node.innerHTML = text;
      var content = node.textContent;
      return content.length > length
        ? content.slice(0, length) + clamp
        : content;
    },
    toggleShow() {
      this.show = !this.show;
    },
    cropSuccess(imgDataUrl, field) {
      this.fields.image = imgDataUrl;
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
    reset() {
      this.fields = {};
    },
    close() {
      this.addNew_Dialog = false;
      this.reset();
    },
    save() {
      if (!this.fields.name) {
        return;
      }
      this.addNew_Dialog = false;

      this.submit();
    }
  },
  computed: {
    authors() {
      return this.$store.state.authors;
    }
  }
};
</script>


<style scoped>
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: 0.5;
  position: absolute;
  width: 100%;
}
</style>
