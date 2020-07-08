<template>
  <div>
    <v-row class="supplierDisplayContainer">
      <p style="text-align: center;">
        supplier
        <br />
        <span style="font-size: 50px">{{supplier.name}}</span>
      </p>
      <br />
    </v-row>
    <v-row class="mx-auto">
      <v-col cols="12" md="12">
        <v-row justify="space-between">
          <h3 v-if="supplier.books.length > 0">Books - {{supplier.books.length}}</h3>
          <h3
            style="text-align:center;color:grey;"
            v-else
          >There is no book belonging to {{supplier.name}}</h3>
          <v-menu offset-y style="text-align:right">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark v-bind="attrs" v-on="on">Detail</v-btn>
            </template>
            <v-list>
              <v-list-item>
                  <p>Phone no - {{ supplier.phno }}</p>
              </v-list-item>
              <v-list-item>
                  <p>Address - {{ supplier.address }}</p>
              </v-list-item>
              <v-list-item>
                  <p>Email - {{ supplier.email }}</p>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-row>

        <br />
        <div v-for="(book,index) in supplier.books" :key="index">
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
  computed: {
    supplier() {
      return this.$store.state.supplierview;
    }
  }
};
</script>

<style lang="css" scoped>
.supplierDisplayContainer {
  justify-content: center;
  background-color: #4056b5;
  margin-top: 0px;
  padding: 40px 0px;
}
</style>
