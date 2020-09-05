import StateHandler from './StateHandler.js';
import AdminNotiHandler from './adminNotiHandler';
import VueRouter from 'vue-router';
export default {
  mixins: [StateHandler, AdminNotiHandler],
  data() {
    return {
      fields: {},
      errors: {},
      target_item: {},
      statename: null,
      success: false,
      alert: false,
      alertMessage: '',
      alertType: '',
      addNew_Dialog: false,
      updateDialog: false,
      editDialog: false,
      deleteDialog: false,
    }
  },
  watch: {
    loading : function(value){
      console.log(value);
    }
  },
  methods: {
    //test function to wait response from server .. use like this -> .then(this.sleeper(5000))
    // sleeper(ms) {
    //   return function(x) {
    //     return new Promise(resolve => setTimeout(() => resolve(x), ms));
    //   };
    // },
    submitCreate() {
      this.loading = true;
      axios.post(`/admin/${this.statename}/add${this.changeSingular(this.statename)}`, this.fields).then(response => {
        
        this.loading = false;
        axios.get(`/api/admin/${this.statename}/lastrecord`).then(({data}) => {
          // ############################### current off cuz of pusher error ##############################
          // this.create_admin_noti('create', data);
          this.$router.push({name: 'bookview', params: {id : data.id}})
        });
        this.alertMessage = 'Item created successfully';
        this.alertType = "success";
        this.alert = true;
        this.addNew_Dialog = false;
        this.target_item = null;
        this.fields = {};
        this.errors = {};
      }).catch(error => {
        console.log('got error in crud');
        console.log(error.response);
        console.log(error);
        if (error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        }
      });
    },
    submitEdit() {
      axios.post(`/admin/${this.statename}/update/${this.target_item.id}`, this.fields).then(() => {
        console.log('enter edit');
        // this.replacerecord(this.statename,this.target_item.id);
        this.create_admin_noti('edit',this.target_item)
        this.alertType = "success";
        this.alertMessage = (this.target_item.name)? `${this.changeSingular(this.statename)} ${this.target_item.name} is edited successfully` : `${this.changeSingular(this.statename)} id:${this.target_item.id} edited successfully`;
        this.alert = true;
        this.editDialog = false;
        this.target_item = null;
        this.fields = {};
        this.errors = {};
      }).catch(error => {
        console.log('got error in crud');
        console.log(error);
        console.log(error.response);
        if (error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        }
      });
    },
    submitDelete() {
      axios.post(`/admin/${this.statename}/delete/${this.target_item.id}`).then(() => {
        console.log('enter delete');
        // this.deleterecord(this.statename,this.target_item.id);
        this.create_admin_noti('delete',this.target_item)
        this.alertType = "success";
        this.alertMessage = (this.target_item.name)? `${this.changeSingular(this.statename)} ${this.target_item.name} is deleted successfully` : `${this.changeSingular(this.statename)} id:${this.target_item.id} deleted successfully`;
        this.alert = true;
        this.deleteDialog = false;
        this.target_item = null;
        this.fields = {};
        this.errors = {};
      }).catch(error => {
        console.log('got error in crud');
        console.log(error);
        console.log(error.response);
        if (error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        }
      });
    },
    changeSingular(name){
      switch(name) {
        case 'admins' : return 'admin';
        case 'books' : return 'book';
        case 'authors' : return 'author';
        case 'users' : return 'user';
        case 'tags' : return 'tag';
        case 'categories' : return 'category';
        case 'suppliers' : return 'supplier';
        case 'publishers' : return 'publisher';
        case 'comments' : return 'comment';
        case 'orders' : return 'order';
        case 'notifications' : return 'notification';
      }
    }
  }
}