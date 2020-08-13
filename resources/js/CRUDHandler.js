import StateHandler from './StateHandler.js';
// import AdminNotiHandler from './adminNotiHandler';
export default {
  mixins: [StateHandler],
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
  methods: {
    submitCreate() {
      axios.post(`/admin/${this.statename}/${this.changeSingular(this.statename)}`, this.fields).then(() => {
        console.log('enter create');
        this.lastrecord(this.statename);
        // this.create_admin_noti('admin_create',this.target_item);
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
        // if (error.response.status === 422) {
        //   this.errors = error.response.data.errors || {};
        // }
      });
    },
    submitEdit() {
      axios.post(`/admin/${this.statename}/update/${this.target_item.id}`, this.fields).then(() => {
        console.log('enter edit');
        this.replacerecord(this.statename,this.target_item.id);
        // this.create_admin_noti('admin_edit',this.target_item)
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
        // if (error.response.status === 422) {
        //   this.errors = error.response.data.errors || {};
        // }
      });;
    },
    submitDelete() {
      axios.post(`/admin/${this.statename}/delete/${this.target_item.id}`).then(() => {
        console.log('enter delete');
        this.deleterecord(this.statename,this.target_item.id);
        // this.create_admin_noti('admin_delete',this.target_item)
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
        // if (error.response.status === 422) {
        //   this.errors = error.response.data.errors || {};
        // }
      });;
    },
    changeSingular(name){
      switch(name) {
        case 'admins' : return 'admin';break;
        case 'books' : return 'book';break;
        case 'authors' : return 'author';break;
        case 'users' : return 'user';break;
        case 'tags' : return 'tag';break;
        case 'categories' : return 'category';break;
        case 'suppliers' : return 'supplier';break;
        case 'publishers' : return 'publisher';break;
        case 'comments' : return 'comment';break;
        case 'orders' : return 'order';break;
        case 'notifications' : return 'notification';break;
      }
    }
  }
}