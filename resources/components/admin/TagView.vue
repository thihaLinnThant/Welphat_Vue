<template>
    <div>
      <v-row class="tagDisplayContainer">
        #{{tags.name}}
      </v-row>
      <v-row class="mx-auto">
        <v-col cols="12" md="12">
          <h3 v-if="tags.books.length > 0">Books ( {{tags.books.length}} )</h3>
          <h3 style="text-align:center;color:grey;" v-else>There is no book belonging to {{tags.name}}</h3>
          <br />
          <div v-for="(book,index) in tags.books" :key="index">
            <v-card>
              <v-row>
                <v-col cols="12" md="3">
                  <img :src="book.thumb" style="width: 100%;height: 250px;" />
                </v-col>
                <v-col cols="12" md="9" style="padding: 0px 30px 10px 30px">
                  <h1>{{book.name}}</h1>
                  <h4 style="color:yellow">Price - {{book.price}} ks</h4>
                  <br />
                  <p>{{book.description}}</p>
                  <p>Published on - {{book.published_date}}</p>
                  <v-row>
                    <v-spacer></v-spacer>
                    <router-link :to="'/admin/books/'+ book.id" style="text-decoration: none">
                      <v-btn outlined rounded>view book</v-btn>
                    </router-link>
                  </v-row>
                </v-col>
              </v-row>
            </v-card>
            <br />
          </div>
        </v-col>
      </v-row>
    </div>
</template>

<script>
export default {
  computed:{
    tags(){
      return this.$store.state.tagview;
    }
  }
}
</script>

<style media="screen">
  .tagDisplayContainer{
    text-align: center;
    justify-content: center;
    font-size :50px;
    background-color: #4056B5;
    margin-top: 0px;
    padding : 40px 0px;

  }
</style>
