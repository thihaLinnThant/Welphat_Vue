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
        <p>
          <span style="color:grey">Joined Since -</span>
          {{joinDate(user.created_at)}}
        </p>
        <p v-if="user.order_count != 0">Order မှာယူမှု {{user.order_count}} ကြိမ် ပြုလုပ်ပြီးပါပြီ</p>
        <p v-else>Order မှာယူမှုမရှိသေးပါ</p>
      </v-col>
    </v-row>
    <v-tabs>
      <v-tab>Orders</v-tab>
      <v-tab-item>
        <v-card flat tile v-if="user.orders.length>0">
          <div v-for="(order,index) in user.orders" :key="index">
            <v-card-text>
              <v-expansion-panels>
                <v-expansion-panel v-for="(item,i) in 5" :key="i">
                  <v-expansion-panel-header>Item</v-expansion-panel-header>
                  <v-expansion-panel-content>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</v-expansion-panel-content>
                </v-expansion-panel>
              </v-expansion-panels>
            </v-card-text>
          </div>
        </v-card>
      </v-tab-item>
      <v-tab>Comments</v-tab>
      <v-tab-item>
        <v-card flat tile>
          <v-card-text>this is wish list</v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab>Suppliers</v-tab>
      <v-tab-item>
        <v-card flat tile>
          <v-card-text>this is wish comments</v-card-text>
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
    }
  },
  computed: {
    user() {
      return this.$store.state.userview;
    }
  }
};
</script>