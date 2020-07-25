<template>
  <div>
    <v-row justify="center">
      <!-- ########################################## ORDERS ############################################ -->
      <v-col cols="6" md="3" v-for="(statusTable,index) in statusTables" :key="index">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>{{statusTable.statusName}}</div>
                <p class="display-1 text--primary">
                  <animated-number
                    :value="overview[statusTable.statusTable][orderCountsFilter]"
                    :formatValue="format"
                    :duration="500"
                  />
                </p>
                <p>
                  <v-icon color="yellow">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="overview.orderCount.newAdded"
                      :formatValue="format"
                      :duration="500"
                    />new
                  </span>
                  <span class="styledDot">.</span>
                  <v-icon color="green">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="(overview.orderCount.newAdded/(overview.orderCount.current-overview.orderCount.newAdded))*100"
                      :formatValue="format"
                      :duration="500"
                    />%
                  </span>
                </p>
              </v-col>

              <v-col cols="12" md="4">
                <v-select
                  :items="orderItems"
                  dense
                  v-model="orderDefaultItem"
                  item-text="name"
                  item-value="value"
                  @change="changedValue($event,'orderCountsFilter')"
                ></v-select>
                <v-icon color="secondary" size="50" class="d-none d-sm-block">mdi-briefcase</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name: 'books'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <!-- ########################################## ORDERS END ############################################ -->
      <!-- ########################################## USERS ############################################ -->
      <!-- <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Users</div>
                <p class="display-1 text--primary">
                  <animated-number
                    :value="overview.usersCount[userCountsFilter]"
                    :formatValue="format"
                    :duration="500"
                  />
                </p>
                <p>
                  <v-icon color="yellow">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="overview.usersCount.newAdded"
                      :formatValue="format"
                      :duration="500"
                    />new
                  </span>
                  <span class="styledDot">.</span>
                  <v-icon color="green">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="(overview.usersCount.newAdded/(overview.usersCount.current-overview.usersCount.newAdded))*100"
                      :formatValue="format"
                      :duration="500"
                    />%
                  </span>
                </p>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  :items="userItems"
                  dense
                  v-model="userDefaultItem"
                  item-text="name"
                  item-value="value"
                  @change="changedValue($event,'userCountsFilter')"
                ></v-select>
                <v-icon color="secondary" size="50" class="d-none d-sm-block">mdi-account</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name : 'users'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col> -->
      <!-- ################################################# USERS END ######################################### -->
      <!-- ########################################## BOOK ############################################ -->
      <!-- <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Books</div>
                <p class="display-1 text--primary">
                  <animated-number
                    :value="overview.booksCount[bookCountsFilter]"
                    :formatValue="format"
                    :duration="500"
                  />
                </p>
                <p>
                  <v-icon color="yellow">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="overview.booksCount.newAdded"
                      :formatValue="format"
                      :duration="500"
                    />new
                  </span>
                  <span class="styledDot">.</span>
                  <v-icon color="green">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="(overview.booksCount.newAdded/(overview.booksCount.current-overview.booksCount.newAdded))*100"
                      :formatValue="format"
                      :duration="500"
                    />%
                  </span>
                </p>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  :items="bookItems"
                  dense
                  v-model="bookDefaultItem"
                  item-text="name"
                  item-value="value"
                  @change="changedValue($event,'bookCountsFilter')"
                ></v-select>
                <v-icon color="secondary" size="50" class="d-none d-sm-block">mdi-book</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name: 'books'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col> -->
      <!-- ################################# BOOK END ######################################### -->
      <!-- ################################# INCOME ######################################### -->
      <v-col cols="6" md="3">
        <v-card>
          <v-card-text>
            <v-row>
              <v-col cols="12" md="8">
                <div>Income</div>
                <p class="display-1 text--primary">
                  <animated-number
                    :value="overview.income[incomeCountsFilter]"
                    :formatValue="format"
                    :duration="500"
                  />
                  <span style="font-size:15px;color:grey;">mmk</span>
                </p>
                <p>
                  <v-icon color="yellow">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="overview.income.incomeTdy"
                      :formatValue="format"
                      :duration="500"
                    />
                    <span style="font-size:10px;color:grey;">mmk</span>
                  </span>
                  <span class="styledDot">.</span>
                  <v-icon color="green">mdi-trending-up</v-icon>
                  <span>
                    +
                    <animated-number
                      :value="(overview.income.incomeTdy/(overview.income.incomeAll-overview.income.incomeTdy))*100"
                      :formatValue="format"
                      :duration="500"
                    />%
                  </span>
                </p>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  :items="incomeItems"
                  dense
                  v-model="incomeDefaultItem"
                  item-text="name"
                  item-value="value"
                  @change="changedValue($event,'incomeCountsFilter')"
                ></v-select>
                <v-icon color="secondary" size="50" class="d-none d-sm-block">mdi-cash</v-icon>
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-btn block elevation="0" :to="{ name: 'orders'}">view detail</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      <!-- ################################# INCOME END ######################################### -->
    </v-row>
    <!-- ################################# ORDER STATUS DETAIL ######################################### -->

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

    <!-- ################################# ORDER STATUS DETAIL END ######################################### -->
    <!-- ################################# TOP COLLECTIONS ######################################### -->

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
    </v-row>

    <!-- ################################# TOP COLLECTIONS END######################################### -->
  </div>
</template>

<script>
import AnimatedNumber from "animated-number-vue";
export default {
  components: {
    AnimatedNumber
  },
  data() {
    return {
      bookCountsFilter: "newAdded",
      userCountsFilter: "newAdded",
      orderCountsFilter: "newAdded",
      incomeCountsFilter: "incomeTdy",
      statusTables: [
        {
          statusName: "Orders",
          statusTable: "orderCount"
        },
        {
          statusName: "Users",
          statusTable: "userCount"
        },
        {
          statusName: "Books",
          statusTable: "bookCount"
        }
      ],
      selectAbleItems: [
        {
          name: "Today",
          value: "newAdded"
        },
        {
          name: "all",
          value: "current"
        },
        {
          name: "last 7 days",
          value: "lastSevenDays"
        },
        {
          name: "last 1 month",
          value: "lastMonth"
        },
        {
          name: "last 30 days",
          value: "last30Days"
        }
      ],
      orderItems: [
        {
          name: "Today",
          value: "newAdded"
        },
        {
          name: "all",
          value: "current"
        },
        {
          name: "last 7 days",
          value: "lastSevenDays"
        },
        {
          name: "last 1 month",
          value: "lastMonth"
        },
        {
          name: "last 30 days",
          value: "last30Days"
        }
      ],
      userItems: [
        {
          name: "Today",
          value: "newAdded"
        },
        {
          name: "all",
          value: "current"
        },
        {
          name: "last 7 days",
          value: "lastSevenDays"
        },
        {
          name: "last 1 month",
          value: "lastMonth"
        },
        {
          name: "last 30 days",
          value: "last30Days"
        }
      ],
      bookItems: [
        {
          name: "Today",
          value: "newAdded"
        },
        {
          name: "all",
          value: "current"
        },
        {
          name: "last 7 days",
          value: "lastSevenDays"
        },
        {
          name: "last 1 month",
          value: "lastMonth"
        },
        {
          name: "last 30 days",
          value: "last30Days"
        }
      ],
      incomeItems: [
        {
          name: "Today",
          value: "incomeTdy"
        },
        {
          name: "all",
          value: "incomeAll"
        },
        {
          name: "last 7 days",
          value: "incomeLast7Days"
        },
        {
          name: "last 1 month",
          value: "incomeLastMonth"
        },
        {
          name: "last 30 days",
          value: "incomeLast30Days"
        }
      ],
      userDefaultItem: { name: "Today", value: "newAdded" },
      orderDefaultItem: { name: "Today", value: "newAdded" },
      bookDefaultItem: { name: "Today", value: "newAdded" },
      incomeDefaultItem: { name: "Today", value: "incomeTdy" }
    };
  },
  computed: {
    overview() {
      return this.$store.state.overview;
    },
    bestSelling() {
      return this.$store.state.overview.bestSelling;
    }
  },
  methods: {
    changedValue: function(value, param) {
      console.log(value);
      this[param] = value;
    },
    format(value) {
      return value.toFixed(0);
    }
  }
};
</script>

<style lang="css" scoped>
.styledDot {
  font-size: 30px;
}
</style>
