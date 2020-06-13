<template>
  <v-container fluid>
    <v-row class="d-flex">
      <h2>Authors</h2>
      <v-spacer></v-spacer>

      <v-btn class="ml-5" outlined @click="addNew_Dialog = true">Create New +</v-btn>
    </v-row>
    <v-row>
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
      <v-col cols="12" md="3" v-for="author in authors" :key="author.id">
        <v-card max-width="344" class="mx-auto">
          <v-hover v-slot:default="{ hover }">
            <v-img class="white--text align-end" height="200px" :src="author.thumb">
              <v-expand-transition>
                <div
                  v-if="hover"
                  class="d-flex transition-fast-in-fast-out orange darken-2 v-card--reveal display-3 white--text"
                  style="height: 100%;cursor:pointer"
                >View</div>
              </v-expand-transition>
            </v-img>
          </v-hover>

          <!-- image is temporary. you can change it later like ":src="author.thumb"" -->
          <v-card-title>{{ author.name }}</v-card-title>
          <v-card-subtitle>books: {{author.count}}</v-card-subtitle>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn>Edit</v-btn>
            <v-btn>Delete</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
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
      addNew_Dialog: false,
      act: "/admin/authors/register",
      image_file: null,
      image_url: " ",
      show: false,
      statename: "authors"
    };
  },

  methods: {
    toggleShow() {
      this.show = !this.show;
    },
    /**
     * crop success
     *
     * [param] imgDataUrl
     * [param] field
     */
    cropSuccess(imgDataUrl, field) {
      // // This ready to use cropper only provide dataurl!!
      // // A function to change dataurl to file. I don't know how it works!! ( T_T )
      // function dataURLtoFile(dataurl, filename) {
      //     var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
      //     bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
      //     while(n--){
      //         u8arr[n] = bstr.charCodeAt(n);
      //     }
      //     return new File([u8arr], filename, {type:mime});
      // }
      // this.image_file = dataURLtoFile(imgDataUrl, 'upload.png');
      // this.image_url = imgDataUrl;
      this.fields.image = imgDataUrl;

      console.log("-------- crop success --------");
    },
    /**
     * upload success
     *
     * [param] jsonData  server api return data, already json encode
     * [param] field
     */
    cropUploadSuccess(jsonData, field) {
      console.log("-------- upload success --------");
      console.log(jsonData);
      console.log("field: " + field);
    },
    /**
     * upload fail
     *
     * [param] status    server api return error status, like 500
     * [param] field
     */
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
