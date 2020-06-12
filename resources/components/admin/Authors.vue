<template>
  <v-container fluid>
    <v-row class="d-flex">
      <h2>Authors</h2>
      <v-spacer></v-spacer>
      <router-link tag="p" to="authors/register">
        <v-btn class="ml-5" outlined>Create New +</v-btn>
      </router-link>
    </v-row>
    <v-row>
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
          <v-card-subtitle>books: {{author.thumb}}</v-card-subtitle>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn>Edit</v-btn>
            <v-btn>Delete</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
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
