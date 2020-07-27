<template>
<div>
  <v-dialog
    v-model="deleteDialog"
    max-width="350"
    persistent
  >
    <v-card>
      <v-card-text>
        Do you want to delete this notification?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          text
          @click="deleteDialog = false; target_item = '';"
          color="primary" outlined
        >
          No
        </v-btn>

        <v-btn
          text
          @click="deleteDialog = false; submitDelete(target_item.id,target_item.name);"
        >
          Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

      <v-snackbar v-model="alert" color="success">
      {{alertMessage}}
      <v-btn text @click="alert = false">Close</v-btn>
    </v-snackbar>
    <div>
      <v-card>
        <v-card-title>
          Notifications
        </v-card-title>
        <v-data-table v-model="selected" show-select :headers="headers" :items="notifications" :search="search" item-key="id">
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
          <template #item.seen="{value}">
            <div :class="{dot: !value}"></div>
          </template>
        </v-data-table>
      </v-card>
    </div>
  </div>
</template>

<script>
import InputMixin from '../../js/RecordInputmixin';
import EditMixin from '../../js/editFrom';
import DeleteMixin from '../../js/deleteForm';
import LastRecordMixin from '../../js/lastRecordmixin';

export default {
  mixins: [InputMixin,EditMixin, DeleteMixin,LastRecordMixin],
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
        { text: "unseen", value: "seen"},
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
