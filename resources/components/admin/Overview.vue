<template>
  <div>
    <v-row justify="center">
      <v-col cols="6" md="4">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Orders</div>
                <p class="display-1 text--primary">
                  <animated-number
                    :value="overview.booksCount.current + overview.booksCount.newAdded"
                    :formatValue="format"
                    :duration="2000"
                  />
                </p>
                <p>
                  new order
                  <v-icon color="green">mdi-arrow-top-right</v-icon>
                  <span style="color:green">
                    +
                    <animated-number
                      :value="overview.booksCount.newAdded"
                      :formatValue="format"
                      :duration="2000"
                    />
                  </span>
                </p>
              </v-col>
              <v-col cols="12" md="4" class="d-none d-sm-block">
                <v-icon color="secondary" size="50">mdi-book</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name: 'books'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="6" md="4">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Users</div>
                <p class="display-1 text--primary">
                  <animated-number
                    :value="overview.usersCount.current + overview.usersCount.newAdded"
                    :formatValue="format"
                    :duration="2000"
                  />
                </p>
                <p>
                  new user
                  <v-icon color="green">mdi-arrow-top-right</v-icon>
                  <span style="color:green">
                    +
                    <animated-number
                      :value="overview.usersCount.newAdded"
                      :formatValue="format"
                      :duration="2000"
                    />
                  </span>
                </p>
              </v-col>
              <v-col cols="12" md="4" class="d-none d-sm-block">
                <v-icon color="secondary" size="50">mdi-account</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name : 'users'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="12" md="4">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Income</div>
                <v-row justify="space-between">
                  <p class="display-1 text--primary" style="margin-left:10px">
                    <animated-number
                      :value="overview.income.incomeAll+overview.income.incomeTdy"
                      :formatValue="format"
                      :duration="2000"
                    />
                    <span style="color:grey;font-size: 20px;margin-top: 10px">mmk</span>
                  </p>
                </v-row>

                <p>
                  today income
                  <v-icon color="green">mdi-arrow-top-right</v-icon>
                  <span style="color:green">
                    <animated-number
                      :value="overview.income.incomeTdy"
                      :formatValue="format"
                      :duration="2000"
                    />mmk
                  </span>
                </p>
              </v-col>
              <v-col cols="12" md="4" class="d-none d-sm-block">
                <v-icon color="secondary" size="50">mdi-square-inc-cash</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name: 'orders'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="6" md="3">
        <v-card color="#EBA276">
          <v-card-subtitle>In Progress</v-card-subtitle>
          <v-card-title class="headline">9</v-card-title>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="6" md="3">
        <v-card color="green" dark>
          <v-card-subtitle>Delivered</v-card-subtitle>
          <v-card-title class="headline">9</v-card-title>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="6" md="3">
        <v-card color="#6663C7" dark>
          <v-card-subtitle>Canceled</v-card-subtitle>
          <v-card-title class="headline">9</v-card-title>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="6" md="3">
        <v-card color="red" dark>
          <v-card-subtitle>Passed Due</v-card-subtitle>
          <v-card-title class="headline">9</v-card-title>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import AnimatedNumber from "animated-number-vue";
export default {
  components: {
    AnimatedNumber
  },
  computed: {
    overview() {
      return this.$store.state.overview;
    }
  },
  methods: {
    format(value) {
      return value.toFixed(0);
    }
  }
};
</script>

<style lang="css" scoped>
</style>
