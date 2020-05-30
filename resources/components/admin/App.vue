<template>    
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
            clipped
        >
            <v-list class="nav-list" dense>
                <v-list-item >
                    <v-list-item-action>
                        <v-avatar color="indigo">
                            <v-icon dark>mdi-account-circle</v-icon>
                        </v-avatar>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>ADMIN NAME</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <hr>
                <div v-for="(item, i) in items" :key="i">
                    <router-link :to="{ name: item.link }">
                        <v-list-item :inactive=item.inactive link>
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
    
        <v-app-bar
            app
            clipped-left
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>WelPhat Admin Panel</v-toolbar-title>
            <!-- <v-spacer></v-spacer> -->
            <v-btn @click="logout" class="ml-5" outlined >Logout</v-btn>
            <form id="logout_form" method="POST" action="/logout" sytle="display:hidden"><input type="hidden" name="_token" :value="csrf_token"/></form>
        </v-app-bar>
    
        <v-content>
            <v-container fluid>                
                <router-view></router-view>
            </v-container>
        </v-content>
    
        <v-footer app>
            <span>&copy; 2020</span>
        </v-footer>
    </v-app>
</template>

<script>
// url_str = window.location.pathname;

  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
      csrf_token: window.csrf_token,
      items: [
        { text: 'Books' , icon: 'fas fa-book' , link: 'books', inactive: false},
        { text: 'Admins' , icon: 'fas fa-user-shield', link: 'dummy', inactive: false },
        { text: 'Users' , icon: 'fas fa-user', link: 'dummy', inactive: false },
        { text: 'Authors' , icon: 'fas fa-feather-alt', link: 'authors', inactive: false },
        { text: 'Categories' , icon: 'fas fa-list', link: 'categories', inactive: false },
        { text: 'Tags' , icon: 'fas fa-tags', link: 'tags', inactive: false  },
        { text: 'Comments' , icon: 'fas fa-comments', link: 'dummy', inactive: false  },
        { text: 'Publishers' , icon: 'fas fa-building', link: 'publishers', inactive: false },
        { text: 'Orders' , icon: 'fas fa-clipboard-list', link: 'dummy', inactive: false  }
      ]      
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
    methods: {
        logout() {
            document.getElementById('logout_form').submit();
        }
    }
  }
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