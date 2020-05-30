<template>    
    <v-form class="ma-10" enctype="multipart/form-data">
        <h2>Author Register</h2>             
        <v-row align="center" justify="center" class="ma-10">
            <v-col
                cols="12"
                md="8"
            >
                <v-text-field name="name" v-model="author_name" outlined label="Name"></v-text-field>
                <v-file-input :value="image_file" name="image" @change="Preview_image($event)" outlined label="Upload Image"></v-file-input>
                <v-btn @click="toggleShow">Upload Image</v-btn>
                <my-upload field="img"
                    @crop-success="cropSuccess"
                    @crop-upload-success="cropUploadSuccess"
                    @crop-upload-fail="cropUploadFail"
                    langType="en"
                    v-model="show"
                    :width="300"
                    :height="300"
                    url=""
                    :params="image_file"
                    img-format="png"></my-upload>
                <v-btn type="submit" outlined="">Submit</v-btn>
            </v-col>

            <v-card width="200px">
                <v-img
                    class="white--text align-end"
                    height="200px"                
                    :src="image_url"
                >
                </v-img>
                <v-card-text>{{ author_name }}</v-card-text>
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
            author_name: " ",
            image_file: null,
            image_url: " ",
            show: false
        }
    },
    components: {
        'my-upload': myUpload
    },
    mixins: [InputMixin],
    methods: {
        Preview_image(e) {
            this.image_url = URL.createObjectURL(e);
        },
        toggleShow() {
				this.show = !this.show;
            },
            
        
        /**
         * crop success
         *
         * [param] imgDataUrl
         * [param] field
         */
        cropSuccess(imgDataUrl, field){
            console.log('-------- crop success --------');
            this.image_url = imgDataUrl;
            convertURIToImageData(imgDataUrl).then(function(imageData) {
                // Here you can use imageData
                console.log(imageData);
                this.image_file = imageData;
                
            });

            function convertURIToImageData(URI) {
                return new Promise(function(resolve, reject) {
                    if (URI == null) return reject();
                    var canvas = document.createElement('canvas'),
                    context = canvas.getContext('2d'),
                    image = new Image();
                    image.addEventListener('load', function() {
                        canvas.width = image.width;
                        canvas.height = image.height;
                        context.drawImage(image, 0, 0, canvas.width, canvas.height);
                        resolve(context.getImageData(0, 0, canvas.width, canvas.height));
                    }, false);
                    image.src = URI;                    
                });
            }
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