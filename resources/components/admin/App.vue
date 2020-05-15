<template>    
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
            clipped
        >
            <v-list dense>
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
                
                <v-list-item v-for="(item, i) in items" :key="i" link>
                        <v-list-item-action>
                            <v-icon v-text="item.icon"></v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title v-text="item.text"></v-list-item-title>
                        </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    
        <v-app-bar
            app
            clipped-left
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>WelPhat Admin Panel</v-toolbar-title>
            <!-- <v-spacer></v-spacer> -->
            <v-btn class="ml-5" outlined >Logout</v-btn>
        </v-app-bar>
    
        <v-content>
            <v-container
            class="fill-height"
            fluid
            >
            <v-row
                align="center"
                justify="center"
            >
                <v-col class="shrink">
                <v-tooltip right>
                    <template v-slot:activator="{ on }">
                    <v-btn
                        :href="source"
                        icon
                        large
                        target="_blank"
                        v-on="on"
                    >
                        <v-icon large>mdi-code-tags</v-icon>
                    </v-btn>
                    </template>
                    <span>Source</span>
                </v-tooltip>
                </v-col>
            </v-row>
            </v-container>
        </v-content>
    
        <v-footer app>
            <span>&copy; 2020</span>
        </v-footer>
    </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
      item: 1,
      items: [
        { text: 'Books' , icon: 'fas fa-book' },
        { text: 'Admins' , icon: 'fas fa-user-shield' },
        { text: 'Users' , icon: 'fas fa-user' },
        { text: 'Authors' , icon: 'fas fa-feather-alt' },
        { text: 'Categories' , icon: 'fas fa-list' },
        { text: 'Tags' , icon: 'fas fa-tags' },
        { text: 'Comments' , icon: 'fas fa-comments' },
        { text: 'Publishers' , icon: 'fas fa-building' },
        { text: 'Orders' , icon: 'fas fa-clipboard-list' }
      ]
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
  }
</script>