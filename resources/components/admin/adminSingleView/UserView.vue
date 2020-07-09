<template>
  <div>
    <v-row class="mx-auto">
      <v-col cols="5" md="2">
        <v-avatar size="110" class="mx-auto">
          <v-img :src="user.thumb" v-if="user.thumb"></v-img>
          <v-img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQD6o4MplGmPR_M3Z_mSwecQ3cKlpZzaJOyhQ&usqp=CAU"
          ></v-img>
        </v-avatar>
      </v-col>
      <v-col cols="7" md="10">
        <h2>{{user.name}}</h2>
        <small>{{user.email}}</small>
        <p>
          <span style="color:grey">Joined Since -</span>
          {{joinDate(user.created_at)}}
        </p>
        <p>
          <span style="color:grey">Phone-</span>
          {{user.ph_no || 'empty'}}
        </p>
        <p v-if="user.order_count != 0">Order မှာယူမှု {{user.order_count}} ကြိမ် ပြုလုပ်ထားပါသည်</p>
        <p v-else>Order မှာယူမှုမရှိသေးပါ</p>
      </v-col>
    </v-row>
    <v-tabs>
      <v-tab>
        <v-badge color="green" :content="user.order_count || '0'">Orders</v-badge>
      </v-tab>
      <v-tab-item>
        <v-card flat tile v-if="user.orders.length>0">
          <v-card-text>
            <v-expansion-panels>
              <v-expansion-panel v-for="(order,index) in user.orders" :key="index">
                <v-expansion-panel-header>
                  <v-row>
                    <v-col cols="1">
                      <span style="color:grey">Order ID -</span>
                      {{order.id}}
                    </v-col>
                    <v-col cols="2">
                      <span style="color:grey">Phone Number -</span>
                      {{order.phone_no}}
                    </v-col>
                    <v-col cols="4">
                      <span style="color:grey">Address -</span>
                      {{order.address}}
                    </v-col>
                    <v-col cols="1">
                      <v-avatar size="15" :color="colorStatus(order.status)"></v-avatar>
                    </v-col>
                    <v-col cols="4">
                      <span style="color:grey">Ordered -</span>
                      {{joinDate(order.created_at)}}
                    </v-col>
                  </v-row>
                </v-expansion-panel-header>

                <v-expansion-panel-content>
                  <v-row align="start">
                    <v-card
                      v-for="(book,index) in order.books"
                      :key="index"
                      class="ma-2"
                      elevation="0"
                    >
                      <v-list-item>
                        <v-list-item-subtitle>
                          <span>
                            {{book.book_name}}
                            <br />
                            qty:({{book.qty}})
                            <br />
                            total : {{book.qty*book.book_price}}
                          </span>
                        </v-list-item-subtitle>
                        <v-card-actions>
                          <router-link
                            :to="{ name: 'bookview', params: { id: book.book_id }}"
                            style="text-decoration:none"
                          >
                            <v-btn small dense outlined>view book</v-btn>
                          </router-link>
                        </v-card-actions>
                      </v-list-item>
                    </v-card>
                  </v-row>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab>Comments</v-tab>
      <v-tab-item>
        <v-card flat tile>
          <div v-if="user.comments.length>0">
            <div v-for="(comment,index) in user.comments" :key="index">
              <v-card-text>
                "{{comment.comment_text}}"
                <router-link
                  :to="{ name: 'bookview', params: { id: comment.book_id }}"
                >on book ID {{comment.book_id}}</router-link>
              </v-card-text>
            </div>
          </div>
          <v-card-text v-else>No Comments Yet</v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab>Whish List</v-tab>
      <v-tab-item>
        <v-card flat tile>
          <div v-if="user.wishes.length>0">
            <div v-for="(wish,index) in user.wishes" :key="index">
              <v-card-text>
                <v-row>
                  <v-col cols="10">{{wish.book_name}}</v-col>
                  <v-col cols="2">
                    <router-link
                      style="text-decoration:none"
                      :to="{ name: 'bookview', params: { id: wish.book_id }}"
                    >
                      <v-btn>view book</v-btn>
                    </router-link>
                  </v-col>
                </v-row>
              </v-card-text>
            </div>
          </div>
        </v-card>
      </v-tab-item>
    </v-tabs>
  </div>
</template>

<script>
export default {
  methods: {
    joinDate(dateInIso) {
      return new Date(dateInIso);
    },
    colorStatus(status) {
      switch (status) {
        case "code-1(delivered)":
          return "green";
        case "code-2(canceled)":
          return "orange";
        case "code-3(in_progress)":
          return "yellow";
        case "code-4(passed_due)":
          return "red";
      }
    }
  },
  computed: {
    user() {
      return this.$store.state.userview;
    }
  }
};
</script>

<style scoped>
.statusDiv {
  border-radius: 10%;
  width: 2rem;
  height: 2rem;
}
</style>