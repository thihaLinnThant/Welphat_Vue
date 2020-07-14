<template>
  <div>
    <v-row justify="center">
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <div>Orders</div>
            <p
              class="display-1 text--primary"
            >{{overview.booksCount.current + overview.booksCount.newAdded}}</p>
            <p>
              new order
              <v-icon color="green">mdi-arrow-top-right</v-icon>
              <span style="color:green">+{{overview.booksCount.newAdded}}</span>
            </p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <div>Users</div>
            <p
              class="display-1 text--primary"
            >{{overview.usersCount.current + overview.usersCount.newAdded}}</p>
            <p>
              new user
              <v-icon color="green">mdi-arrow-top-right</v-icon>
              <span style="color:green">+{{overview.usersCount.newAdded}}</span>
            </p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <div>Income</div>
            <v-row justify="space-around">
              <p class="display-1 text--primary">{{overview.income}}</p>
              <p style="color:grey;font-size: 15px;margin-top: 10px">mmk</p>
            </v-row>

            <p>
              today income
              <v-icon color="green">mdi-arrow-top-right</v-icon>
              <span style="color:green">+10,000 mmk</span>
            </p>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <div>Budget</div>
            <v-row justify="space-around">
              <p class="display-1 text--primary">5,000,800</p>
              <p style="color:grey;font-size: 15px;margin-top: 10px">mmk</p>
            </v-row>

            <p>
              status
              <v-icon color="red">mdi-arrow-bottom-left</v-icon>
              <span style="color:red">-11000 mmk</span>
            </p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  computed: {
    overview() {
      return this.$store.state.overview;
    }
  }
};
</script>

<style lang="css" scoped>
</style>
