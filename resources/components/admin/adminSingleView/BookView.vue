<template>
  <v-container>
    <v-row>
      <v-btn text icon @click="$router.go(-1)">
        <v-icon>mdi-arrow-left</v-icon>
      </v-btn>
      <h2>{{book.name}}</h2>
      <v-spacer></v-spacer>
      <small style="margin-right:10px">published on {{book.published_date}}</small>
    </v-row>
    <v-row>
      <v-col cols="12" md="2">
        <v-img :src="book.thumb" style="width: 100%" v-if="book.thumb"></v-img>
        <p style="color:yellow;text-align:center;margin-top: 20px">{{book.price}} ks</p>
        <v-rating
          v-model="book.rates"
          color="yellow"
          style="text-align:center"
          background-color="grey darken-1"
          half-increments
          readonly
          small
        ></v-rating>
        <p
          style="color:grey;text-align:center;font-size:10px"
          v-if="book.rates"
        >{{book.rates}} out of 5</p>
        <p style="color:grey;text-align:center;font-size:10px" v-else>no rating yet</p>
        <v-divider></v-divider>
        <br />
        <p class="secondary_text">Publisher</p>
        <router-link :to="{ name: 'publisherview', params: {id : book.publisher.id}}" class="link">
          <p style="text-align:center;font-weight:bold">{{book.publisher.name}}</p>
        </router-link>
        <v-divider></v-divider>
        <br />
        <p class="secondary_text">this book is added to wishlist by</p>
        <v-flex class="text-center">
          <v-avatar
            color="green"
            size="36"
            style="margin: 0 auto"
            justify="center"
          >{{book.wish_count}}</v-avatar>
        </v-flex>
        <br />
        <p class="secondary_text">{{book.wish_count> 1? 'people' : 'person'}}</p>
        <v-divider></v-divider>
        <br />
        <p class="secondary_text">ordered</p>
        <v-flex class="text-center">
          <v-avatar
            color="green"
            size="36"
            style="margin: 0 auto"
            justify="center"
          >{{book.orders.length}}</v-avatar>
        </v-flex>
        <br>
        <p class="secondary_text">{{book.orders.length> 1? 'times' : 'time'}}</p>
      </v-col>
      <v-col cols="12" md="10">
        <v-row>
          <v-col cols="12" md="6">
            <v-list style="background:#121212">
              <v-header>AUTHORS</v-header>
              <v-list-item v-for="(author,index) in book.authors" :key="index">
                <v-list-item-icon>
                  <v-avatar>
                    <v-img :src="author.thumb"></v-img>
                  </v-avatar>
                </v-list-item-icon>
                <v-list-item-content>
                  <router-link :to="{ name: 'authorview', params: {id : author.id}}" class="link">
                    <v-list-item-title v-text="author.name"></v-list-item-title>
                  </router-link>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-col>
          <v-col cols="12" md="6">
            <v-header>CATEGORIES</v-header>
            <br />
            <span v-for="(category,index) in book.categories" :key="index">
              <router-link :to="{ name: 'categoryview', params: { id: category.id} }" class="link">
                <v-chip class="ma-1 link">{{category.name}}</v-chip>
              </router-link>
            </span>

            <v-divider style="margin: 20px"></v-divider>
            <v-header>TAGS</v-header>
            <br />
            <span v-for="(tag,index) in book.tags" :key="index">
              <router-link :to="{ name: 'tagview', params: { id: tag.id} }" class="link">
                <v-chip class="ma-1 link">#{{tag.name}}</v-chip>
              </router-link>
            </span>

            <v-divider style="margin: 20px"></v-divider>
            <v-header>BOOK INFO</v-header>
            <ul>
              <li>Pages - {{book.pages}}</li>
              <li>BookSize - {{book.bookSize}}</li>
              <li>Language - {{book.lang}}</li>
            </ul>
          </v-col>
        </v-row>

        <v-tabs>
          <v-tab>Preview</v-tab>
          <v-tab-item>
            <v-card flat tile>
              <v-card-text>{{book.description}}</v-card-text>
            </v-card>
          </v-tab-item>
          <v-tab>Comments</v-tab>
          <v-tab-item>
            <v-card flat tile v-if="book.comments.length>0">
              <div v-for="(comment,index) in book.comments" :key="index">
                <v-card-text>
                  <v-row style="margin-left:5px">
                    <v-avatar>
                      <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John" />
                    </v-avatar>
                    <div class="comment_content">
                      <router-link
                        :to="{ name: 'userview', params: { id: comment.user_id}}"
                        class="link"
                      >
                        <h3>{{comment.user_info.name}}</h3>
                      </router-link>
                      <p>{{comment.comment_text}}</p>
                    </div>
                  </v-row>
                </v-card-text>
              </div>
            </v-card>
            <v-card flat tile v-else>
              <v-card-text>No comments yet</v-card-text>
            </v-card>
          </v-tab-item>
          <v-tab>Suppliers</v-tab>
          <v-tab-item>
            <v-card flat tile>
              <div v-for="(supplier,index) in book.suppliers" :key="index">
                <v-card-text>
                  <v-row class="comment_content">
                    <router-link
                      :to="{ name: 'supplierview', params: { id: supplier.id }}"
                      style="text-decoration:none"
                    >
                      <h3 class="link">{{supplier.name}}</h3>
                    </router-link>
                    <v-spacer></v-spacer>
                    <p>Ph - {{supplier.phno}}</p>
                    <br />
                  </v-row>

                  <p style="color:grey;">Address</p>

                  <p>{{supplier.address}}</p>
                </v-card-text>
                <v-divider></v-divider>
              </div>
            </v-card>
          </v-tab-item>
        </v-tabs>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  computed: {
    book() {
      return this.$store.state.bookview;
    }
  }
};
</script>


<style scoped>
.link {
  text-decoration: none;
  cursor: pointer;
}
.link:hover {
  text-decoration: underline;
}
.comment_content {
  padding-left: 15px;
}
.secondary_text {
  text-align: center;
  color: grey;
  font-size: 15px;
}
</style>
