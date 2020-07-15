<template>
  <div>
    <v-row justify="center">
      <v-col cols="6" md="3">
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
              <v-col cols="12" md="4">
                <v-icon color="secondary" size="100">mdi-book</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="6" md="3">
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
              <v-col cols="12" md="4">
                <v-icon color="secondary" size="100">mdi-account</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="6" md="3">
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
              <v-col cols="12" md="4">
                <v-icon color="secondary" size="100">mdi-square-inc-cash</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Budget</div>
                <v-row justify="space-between">
                  <p class="display-1 text--primary" style="margin-left:10px">
                    <animated-number value="30000" :formatValue="format" :duration="2000" />
                    <span style="color:grey;font-size: 20px;margin-top: 10px">mmk</span>
                  </p>
                </v-row>

                <p>
                  status
                  <v-icon color="red">mdi-arrow-bottom-left</v-icon>
                  <span style="color:red">-11000 mmk</span>
                </p>
              </v-col>
              <v-col cols="12" md="4">
                <v-icon color="secondary" size="100">mdi-cash-100</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0">view detail</v-btn>
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
