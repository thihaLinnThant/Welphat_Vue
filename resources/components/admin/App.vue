<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list rounded dense>
        <v-list-item :to="{ name: 'overview'}">
          <v-list-item-icon>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-icon>

          <v-list-item-title>Overview</v-list-item-title>
        </v-list-item>

        <v-list-group value="true">
          <template v-slot:activator>
            <v-list-item-title>Tables</v-list-item-title>
          </template>

          <v-list-item v-for="(item, i) in items" :key="i" link :to="{ name: item.link}">
            <v-list-item-title v-text="item.text"></v-list-item-title>
            <v-list-item-icon>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>WelPhat Admin Panel</v-toolbar-title>
      <v-spacer></v-spacer>
      <span style="margin-right:10px">{{ admin_name }}</span>

      <v-menu offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-badge
            bordered
            top
            color="yellow"
            dot
            offset-x="10"
            offset-y="10"
            v-if="super_admin == 1"
          >
            <v-btn text icon v-on="on" :v-bind="attrs">
              <v-icon dark>mdi-account-circle</v-icon>
            </v-btn>
          </v-badge>
          <v-btn text icon v-on="on" :v-bind="attrs" v-else>
            <v-icon dark>mdi-account-circle</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item @click="logout">
            <form id="logout_form" method="POST" action="/logout" sytle="display:hidden">
              <input type="hidden" name="_token" :value="csrf_token" />
            </form>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>

    <v-footer app>
      <span>&copy; 2020@welphat</span>
    </v-footer>
  </v-app>
</template>

<script>
// url_str = window.location.pathname;
// import vueCustomScrollbar from "vue-custom-scrollbar";
export default {
  props: {
    source: String
  },
  // components: {
  //   vueCustomScrollbar
  // },
  data: () => ({
    drawer: null,
    menuValue: null,
    csrf_token: window.csrf_token,
    admin_name: window.admin_name,
    super_admin: window.super_admin,
    items: [
      { text: "Books", icon: "mdi-bookshelf", link: "books", inactive: false },
      {
        text: "Admins",
        icon: "mdi-shield-account",
        link: "admins",
        inactive: false
      },
      { text: "Users", icon: "mdi-account", link: "users", inactive: false },
      {
        text: "Authors",
        icon: "mdi-lead-pencil",
        link: "authors",
        inactive: false
      },
      {
        text: "Categories",
        icon: "mdi-menu",
        link: "categories",
        inactive: false
      },
      {
        text: "Tags",
        icon: "mdi-tag",
        link: "tags",
        inactive: false
      },
      {
        text: "Comments",
        icon: "mdi-message-text",
        link: "comments",
        inactive: false
      },
      {
        text: "Publishers",
        icon: "mdi-office-building",
        link: "publishers",
        inactive: false
      },
      {
        text: "Suppliers",
        icon: "mdi-truck",
        link: "suppliers",
        inactive: false
      },
      {
        text: "Orders",
        icon: "mdi-receipt",
        link: "orders",
        inactive: false
      }
    ]
  }),
  created() {
    this.$vuetify.theme.dark = true;
  },
  methods: {
    logout() {
      document.getElementById("logout_form").submit();
    }
  }
};
</script>
<style>
.v-btn.active .v-icon {
  transform: rotate(-180deg);
}
.nav-list a {
  text-decoration: none;
}
.nav-list hr {
  height: 0px;
  border: 1px solid dimgray;
  width: 90%;
  margin: auto;
}

.scroll-area {
  position: relative;
  margin: auto;
  width: 600px;
  height: 550px;
}
</style>
