<template>
  <div>

    <v-text-field outlined v-model="bookCountsFilter"></v-text-field>
        <p>{{users}}</p>
    <!-- <v-row justify="center">
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Orders</div>
                <p class="display-1 text--primary">
                  <animated-number
                    :value="overview.ordersCount.current + overview.ordersCount.newAdded"
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
                      :value="overview.ordersCount.newAdded"
                      :formatValue="format"
                      :duration="2000"
                    />
                  </span>
                </p>
              </v-col>
              <v-col cols="12" md="4" class="d-none d-sm-block">
                <v-icon color="secondary" size="50">mdi-briefcase</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name: 'books'}">view detail</v-btn>
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
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Books</div>
                <v-row justify="space-between">
                  <p class="display-1 text--primary" style="margin-left:10px">
                    <animated-number
                      :value="overview.booksCount.current+overview.booksCount.newAdded"
                      :formatValue="format"
                      :duration="2000"
                    />
                  </p>
                </v-row>

                <p>
                  new books
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
            <v-btn block elevation="0" :to="{ name: 'orders'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <div>Income</div>
            <v-row justify="space-between">
              <p class="display-1 text--primary" style="margin-left:10px">
                <animated-number
                  :value="overview.income.incomeAll+overview.income.incomeTdy"
                  :formatValue="format"
                  :duration="2000"
                />
              </p>
              <span style="color:grey;font-size: 20px;margin-top: 10px">mmk</span>
            </v-row>

            <p>
              today income
              <v-icon color="green">mdi-arrow-top-right</v-icon>
              <span style="color:green">
                +
                <animated-number
                  :value="overview.income.incomeTdy"
                  :formatValue="format"
                  :duration="2000"
                />mmk
              </span>
            </p>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name: 'orders'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="6" md="3">
        <v-card color="#AF4926">
          <v-card-title class="headline">
            <animated-number
              :value="overview.orderStatus.inProgress"
              :formatValue="format"
              :duration="2000"
            />
          </v-card-title>

          <v-card-actions>
            <v-card-subtitle>In Progress</v-card-subtitle>
            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="6" md="3">
        <v-card color="green" dark>
          <v-card-title class="headline">
            <animated-number
              :value="overview.orderStatus.delivered"
              :formatValue="format"
              :duration="2000"
            />
          </v-card-title>

          <v-card-actions>
            <v-card-subtitle>Delivered</v-card-subtitle>

            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="6" md="3">
        <v-card color="#6663C7" dark>
          <v-card-title class="headline">
            <animated-number
              :value="overview.orderStatus.canceled"
              :formatValue="format"
              :duration="2000"
            />
          </v-card-title>

          <v-card-actions>
            <v-card-subtitle>Canceled</v-card-subtitle>

            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="6" md="3">
        <v-card color="red" dark>
          <v-card-title class="headline">
            <animated-number
              :value="overview.orderStatus.dued"
              :formatValue="format"
              :duration="2000"
            />
          </v-card-title>

          <v-card-actions>
            <v-card-subtitle>Passed Due</v-card-subtitle>
            <v-spacer></v-spacer>
            <v-btn text icon :to="{ name: 'orders'}">
              <v-icon>mdi-launch</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="6">
        <h2 style="margin:5px">Best Selling Books</h2>
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Rank</th>
                <th class="text-left">Name</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(best_selling_book,index) in overview.bestSelling" :key="index">
                <td>{{index+1}}</td>
                <td>{{ best_selling_book.name }}</td>
                <td>
                  <v-btn
                    text
                    :to="{ name: 'bookview', params: { id : best_selling_book.id}}"
                  >see book</v-btn>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>
      <v-col cols="12" md="6">
        <h2 style="margin:5px">Most Wish Books</h2>
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">Rank</th>
                <th class="text-left">Name</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(most_wish_book,index) in overview.mostWish" :key="index">
                <td>{{index+1}}</td>
                <td>{{ most_wish_book.book_name }}</td>
                <td>
                  <v-btn
                    text
                    :to="{ name: 'bookview', params: { id : most_wish_book.book_id}}"
                  >see book</v-btn>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>
    </v-row> -->
  </div>
</template>

<script>
import AnimatedNumber from "animated-number-vue";
export default {
  components: {
    AnimatedNumber
  },
  data(){
    return{
      bookCountsFilter : null
    }
  },
  computed: {
    users() {
      return this.$store.state.overview.booksCount[this.bookCountsFilter];
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
