<template>
<div>
  <v-snackbar v-model="alert" color="success">
    {{alertMessage}}
    <v-btn text @click="alert = false">Close</v-btn>
  </v-snackbar>
    <div>
      <v-card>
        <v-card-title>
          Notifications
          <v-btn 
            class="ml-2"
            small
            outlined 
            v-show="selected.length > 0"
            @click="mark_all_read()"
          >
            marked selected as read
          </v-btn>
        </v-card-title>
        <v-data-table
          v-model="selected"
          show-select
          :headers="headers"
          :items="notifications"
          :sort-by="['created_at']"
          :sort-desc="true"
          :search="search"
          item-key="id"
        >
          <template #item.noti_type="{ value }">
            <p>{{ value }}</p>
          </template>
          <template #item.committer="{ item }">
            <div>
              <v-avatar color="indigo" size="36">
                  <v-icon>mdi-account-circle</v-icon>
              </v-avatar>
              <small>{{ item.committer.name }}({{ item.committer.type }})</small>
            </div>
          </template>
          <template #item.message="{ value }">
              <p>{{ value }}</p>
          </template>
          <template #item.committed_item="{ item }">
              <p>{{ item.committed_item_type }}(id-{{item.committed_item_id}})</p>
          </template>
          <template #item.created_at="{value}">{{dateFormat(value)}}</template>
          <template #item.item_link = "{ value }">
              <v-btn @click="$router.push(value)" outlined="">View Item</v-btn>
          </template>
          <template #item.action="{item}">
            <v-btn v-if=item.seen icon disabled>
              <v-icon>mdi-checkbox-marked</v-icon>
            </v-btn>
            <v-btn v-else icon >
              <v-icon color="indigo">mdi-checkbox-blank-outline</v-icon>
            </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      csrf_token: window.csrf_token,
      search: "",
      selected:[],
      headers: [
        {
          text: "Id",
          align: "start",
          value: "id"
        },
        { text: "type", value: "noti_type"},
        { text: "Committer", value: "committer" },
        { text: "Message", value: "message"},
        { text: "Item", value: "committed_item"},
        { text: "Date", value: "created_at"},
        { text: "View item", value: "item_link"},
        { text: "unseen", value: "action"},
      ],
      act: "/admin/notifications/addnotification",
      statename: "notifications",
      deleteDialog: false,
      target_item: '',
      target_item_value: '',
      cascade: null,
    }
  },
  computed: {
    notifications() {
      return this.$store.state.notifications;
    }
  },
  methods: {
    dateFormat(date) {
      var trimed_year = date.substring(0, 4);
      var trimed_month = date.substring(5, 7);
      var trimed_day = date.substring(8, 10);
      return trimed_day + "/" + trimed_month + "/" + trimed_year;
    },
    mark_all_read(){
      let batch = {};
      batch.selected = this.selected.filter(select => !select.seen);
      if(batch.selected.length > 0){
        axios.post('/admin/notifications/batch/markseen', batch).then(() => {
          this.notifications.map(noti => noti.seen = true);
          this.selected = [];
          this.alert = true;
          this.alertMessage = "Marked selected as read";
        }).catch(error => {
          console.log(error.response);
        })
      }else {
        this.alert = true;
        this.alertMessage = "Already Marked read";
      }
    }
  }
};
</script>

<style>
.dot{
  width: 10px;
  height: 10px;
  border-radius: 10px;
  background: indigo;
}
</style>
