<template>
  <div>
    <v-row class="mx-auto">
      <v-col cols="5" md="2">
        <v-avatar size="110" color="primary" class="mx-auto">
          <v-img :src="author.thumb"></v-img>
        </v-avatar>
      </v-col>
      <v-col cols="7" md="10">
        <h2>{{author.name}}</h2>
        <p>{{author.bio}}</p>
      </v-col>
    </v-row>
    <v-row class="mx-auto">
      <v-col cols="12" md="12">
        <h3>Books ( {{author.books.length}} )</h3>
        <br />
        <div v-for="(book,index) in author.books" :key="index">
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
                  <router-link :to="'/admin/books/'+ book.id">
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
  computed: {
    author() {
      return this.$store.state.authorview;
    }
  }
};
</script>
