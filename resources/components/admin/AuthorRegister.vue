<template>
    <v-form class="ma-10" @submit.prevent="submit" enctype="multipart/form-data">
        <h2>Author Register</h2>
        <v-row justify="center" class="ma-10">
            <v-col
                cols="12"
                md="8"
            >
                <v-text-field :error=errors.name :error-messages=errors.name v-model="fields.name" name="name" outlined label="Name"></v-text-field>
                <v-textarea :error=errors.bio :error-messages=errors.bio v-model="fields.bio" name="bio" label="Bio" outlined></v-textarea>
                <v-btn @click="toggleShow">Upload Image</v-btn>
                <small class="text-danger">{{ errors.image }}</small>
                <my-upload field="img"
                    @crop-success="cropSuccess"
                    @crop-upload-success="cropUploadSuccess"
                    @crop-upload-fail="cropUploadFail"
                    langType="en"
                    v-model="show"
                    :width="300"
                    :height="300"
                    url=""
                    img-format="png"></my-upload>
                <v-btn type="submit" outlined="">Submit</v-btn>
            </v-col>

            <v-card width="200px" height="250px">
                <v-img
                    class="white--text align-end"
                    height="200px"
                    :src="fields.image"
                >
                </v-img>
                <v-card-text>{{ fields.name }}</v-card-text>
            </v-card>
        </v-row>
    </v-form>
</template>

<script>
import myUpload from 'vue-image-crop-upload';
import InputMixin from '../../js/RecordInputmixin';
export default {
    data() {
        return {
            act: "/admin/authors/register",
            image_file: null,
            image_url: " ",
            show: false,
            statename: "authors"
        }
    },
    components: {
        // I got the cropper from here "https://vuejsexamples.com/a-beautiful-vue-component-for-image-cropping-and-uploading/"
        'my-upload': myUpload
    },
    mixins: [InputMixin],
    methods: {
        toggleShow() {
				this.show = !this.show;
            },
        selectFile(e) {

            let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);

        },
        createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.fields.image = e.target.result;

                };
                reader.readAsDataURL(file);
                console.log(vm.fields.image);
            },


        /**
         * crop success
         *
         * [param] imgDataUrl
         * [param] field
         */
        cropSuccess(imgDataUrl, field){

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

            console.log('-------- crop success --------');
        },
        /**
         * upload success
         *
         * [param] jsonData  server api return data, already json encode
         * [param] field
         */
        cropUploadSuccess(jsonData, field){
            console.log('-------- upload success --------');
            console.log(jsonData);
            console.log('field: ' + field);
        },
        /**
         * upload fail
         *
         * [param] status    server api return error status, like 500
         * [param] field
         */
        cropUploadFail(status, field){
            console.log('-------- upload fail --------');
            console.log(status);
            console.log('field: ' + field);
        }
    }

}
</script>

<style>

</style>
