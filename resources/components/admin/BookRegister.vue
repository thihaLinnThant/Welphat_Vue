<template>
    <v-form class="ma-10">        
        <h2>Book Register</h2>
        <v-row justify="center">
            <v-col
                cols="12"
                md="6"
            >
                <v-text-field v-model="book_name" outlined label="Name"></v-text-field>
            </v-col>
            <v-col
                cols="12"
                md="6"
            >
                <v-autocomplete outlined multiple label="Author(s)"></v-autocomplete>
            </v-col>
            <v-col
                cols="12"
                md="6"
            >
                <v-autocomplete outlined :items=category_list multiple label="Categories"></v-autocomplete>
            </v-col>
            <v-col
                cols="12"
                md="6"
            >
                <v-autocomplete outlined multiple label="Tags"></v-autocomplete>
            </v-col>
            <v-col
                cols="12"
                md="6"
            >
                <v-autocomplete outlined label="Publisher"></v-autocomplete>
            </v-col>
            <v-col
                cols="12"
                md="6"
            >
                <v-file-input @change="Preview_image($event)" outlined label="Upload Image"></v-file-input >
            </v-col>
            
            <v-card width="250px">
                <v-img
                    class="white--text align-end"
                    height="200px"                
                    :src="image_url"
                >
                    <v-card-title>{{ book_name }}</v-card-title>
                </v-img>
            </v-card>
        </v-row>
    </v-form>
</template>

<script>
export default {
    data() {
        return {            
            book_name: null,
            image_url: " ",
        }
    },
    computed: {
        categories() {
            return this.$store.state.categories;
        },
        category_list() {
            var temp = [];
            for(var item in this.categories){
                temp.push([text => item.name, value => item.id])
            }
            return temp;
        }
    },
    methods: {
        Preview_image(e) {
            this.image_url = URL.createObjectURL(e);
        }
    }

}
</script>

<style>

</style>