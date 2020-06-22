<template>
  <div>
    <v-row class="mx-auto">
      <v-col cols="5" md="2">
        <v-avatar size="110" color="primary" class="mx-auto">AUTHOR</v-avatar>
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
        <div v-for="(books,index) in author.books" :key="index">
          <v-card>
            <v-row>
              <v-col cols="12" md="3" style="padding:0px">
                <img
                  src="https://www.canva.com/learn/wp-content/uploads/2020/06/Black-and-White-Minimalist-Memoir_Inspirational-Book-Cover.jpg"
                  style="width: 100%;height: 250px;"
                />
              </v-col>
              <v-col cols="12" md="9" style="padding: 0px 30px 10px 30px">
                <h1>{{books.name}}</h1>
                <h4 style="color:yellow">Price - {{books.price}} ks</h4><br>
                <p>{{books.description}}</p>
                <p>Published on - {{books.published_date}}</p>
                <v-row>
                    <v-spacer></v-spacer>
                    <v-btn outlined rounded>view book</v-btn>
                </v-row>
              </v-col>
            </v-row>
          </v-card>
          <br>
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
  },
  created() {
    console.log(this.$store.state);
  }
};
</script>
