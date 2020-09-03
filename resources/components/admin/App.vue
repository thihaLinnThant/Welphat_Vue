<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app clipped>
      <v-list rounded dense>
        <v-list-item :to="{ name: 'overview'}">
          <v-list-item-icon>
            <v-icon>mdi-view-dashboard</v-icon>
          </v-list-item-icon>

          <v-list-item-title>OVERVIEW</v-list-item-title>
        </v-list-item>

        <v-list-group value="true">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon>mdi-table</v-icon>
            </v-list-item-icon>
            <v-list-item-title>TABLES</v-list-item-title>
          </template>

          <v-list-item v-for="(item, i) in items" :key="i" link :to="{ name: item.link}">
            <v-list-item-title v-text="item.text"></v-list-item-title>
            <v-list-item-icon>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>
          </v-list-item>
        </v-list-group>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <form id="logout_form" method="POST" action="/logout" sytle="display:hidden">
            <input type="hidden" name="_token" :value="csrf_token" />
          </form>
          <v-btn block color="secondary" @click="logout">Logout</v-btn>
        </div>
      </template>
    </v-navigation-drawer>
    <v-navigation-drawer v-model="noti_drawer" width="auto" temporary app right>
      <v-list>
        <v-list-item style="height:90px;" v-for="(noti, index) in latest_notifications" :key=index>
          <div class="d-flex noti-style" :class="{unseen: !noti.seen }">
            <div>
              <dir>
                <v-avatar color="indigo" size="36">
                  <v-icon>mdi-account-circle</v-icon>
                </v-avatar>
              </dir>
              <small>{{ noti.committer.type }}</small>
            </div>
            <dir class="vl"></dir>
            <div class="noti-message">
              <div>
                <small><b>{{noti.committer.name}}</b></small>
              </div>
              <small>{{ noti.message }}</small>
            </div>
            <dir class="vl"></dir>
            <div>
              <v-btn class="mr-2" icon @click="$router.push(noti.item_link)" >
                <v-icon>mdi-eye</v-icon>
              </v-btn>
              <v-btn v-if=noti.seen icon  disabled>
                <v-icon>mdi-checkbox-marked</v-icon>
              </v-btn>
              <v-btn v-else icon @click="mark_seen(noti.id); noti.seen=true;">
                <v-icon>mdi-checkbox-blank-outline</v-icon>
              </v-btn>
            </div>
          </div>
          
        </v-list-item>
        <v-list-item align=center justify-center>
          <a @click="$router.push({name: 'notifications'})">show all notifications</a>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>WelPhat Admin Panel</v-toolbar-title>
      <v-spacer></v-spacer>
      

      <v-btn @click.stop="noti_drawer = !noti_drawer" class="mr-2" text icon >
        <v-badge
          bordered
          overlap
          :value=unseen_noti
          :content=unseen_noti
          color="red"
        >
          <v-icon dark>mdi-bell</v-icon>
        </v-badge>
      </v-btn>
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
          <!-- <v-list-item @click="refersh_token">
            <v-list-item-title>Refresh token</v-list-item-title>
          </v-list-item> -->
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-content>
      <v-container fluid>
        <v-snackbar v-model="alert" :color="alertType">
          {{alertMessage}}
          <v-btn text @click="alert = false">Close</v-btn>
        </v-snackbar>
        <router-view></router-view>
      </v-container>
    </v-content>

    <v-footer app>
      <span>&copy; 2020@welphat</span>
    </v-footer>
  </v-app>
</template>

<script>
import NotificationHandler from '../../js/adminNotiHandler.js';
export default {
  mixins: [NotificationHandler],
  props: {
    source: String
  },
  data: () => ({
    drawer: null,
    noti_drawer: null,
    menuValue: null,
    csrf_token: window.csrf_token,
    admin_name: window.current_admin.name,
    super_admin: window.super_admin,
    alert: false,
    alertMessage: '',
    alertType: '',
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
      },
      {
        text: "Notifiactions",
        icon: "mdi-bell",
        link: "notifications",
        inactive: false
      }
    ]
  }),
  created() {
    this.$vuetify.theme.dark = true;

    // axios.post('/admin/tokenrefresh', window.current_admin).then(({data}) => {
    //     console.log(data);
    //     window.current_admin.api_token = data;
    //     window.axios.defaults.headers.common= {
    //       'X-Requested-With': 'XMLHttpRequest',
    //       'X-CSRF-TOKEN': window.csrf_token,
    //       'Authorization' : 'Bearer ' + window.current_admin.api_token
    //     };
    // }).catch(error => {
    //     console.log(error.response);
    // });

    axios.get('/api/admin/notifications/latest').then(({data}) => {
        this.$store.commit('addData', { route: 'latest_notifications', data })
    }).catch(error => {
      console.log(error.response);
    });
  },
  mounted() {
    Echo.channel('admin-noti')
      .listen('AdminNotificationEvent', (e) => {
        this.receive_noti(e);
    });
  },
  methods: {
    logout() {
      document.getElementById("logout_form").submit();
    },
    mark_seen(id){
      axios.post(`/admin/notifications/markseen/${id}`).catch(error => {
        console.log(error.response);
      });
    },
    // refersh_token(){
    //   axios.post('/admin/tokenrefresh', window.current_admin).then(({data}) => {
    //     console.log(data);
    //     window.current_admin.api_token = data;
    //     window.axios.defaults.headers.common= {
    //       'X-Requested-With': 'XMLHttpRequest',
    //       'X-CSRF-TOKEN': window.csrf_token,
    //       'Authorization' : 'Bearer ' + window.current_admin.api_token
    //     };
    //   }).catch(error => {
    //     console.log(error.response);
    //   });
    // },
  },
  computed: { 
    latest_notifications(){
      return this.$store.state.latest_notifications;
    },
    unseen_noti(){
      return this.latest_notifications.filter(noti => !noti.seen).length;
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
.vl {
  margin: 5px;
  border-left: 2px solid darkgray;
  height: 50px;
}
.unseen{
  background-color: #311B92;
}
.noti-style{
  border: 1px solid white;
  padding: 10px;
  border-radius:10px;
}
.noti-message{
  width: 250px;
}
/* width */
::-webkit-scrollbar {
  background: #424242;
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #424242;
  border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: grey;
  border-radius: 10px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: indigo;
}
</style>
