<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list class="nav-list" dense>
        <v-list-item>
          <v-list-item-action>
            <v-avatar color="indigo">
              <v-icon dark>mdi-account-circle</v-icon>
            </v-avatar>
          </v-list-item-action>
          <v-list-item-content>


              <v-list-item-title>{{ admin_name }}&nbsp; <v-icon :color="super_admin == 1? 'yellow' : 'grey'">mdi-star</v-icon></v-list-item-title>


          </v-list-item-content>
        </v-list-item>
        <hr />
        <div v-for="(item, i) in items" :key="i">
          <router-link :to="{ name: item.link }">
            <v-list-item :inactive="item.inactive" link>
              <v-list-item-action>
                <v-icon v-text="item.icon"></v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="item.text"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </router-link>
        </div>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>WelPhat Admin Panel</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn @click="logout" class="ml-5" outlined>Logout</v-btn>
      <form id="logout_form" method="POST" action="/logout" sytle="display:hidden">
        <input type="hidden" name="_token" :value="csrf_token" />
      </form>
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

export default {
  props: {
    source: String
  },
  data: () => ({
    drawer: null,
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
.nav-list a {
  text-decoration: none;
}
.nav-list hr {
  height: 0px;
  border: 1px solid dimgray;
  width: 90%;
  margin: auto;
}
</style>
