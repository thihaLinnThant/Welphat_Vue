import StateHandler from './StateHandler'
export default{
    mixins: [StateHandler],
    methods: {
        create_admin_noti(type, item){
            var create_noti = {};
            create_noti.noti_type = 'admin_' + type;
            create_noti.committer_id = window.current_admin.id;
            create_noti.committer_type = 'App\\Admin';
            
            var message_part;
            switch(type){
                case 'create': message_part = 'created';break;
                case 'edit': message_part = 'made changes to';break;
                case 'delete': message_part = 'deleted';break;
            }

            let { item_name, item_type } = this.getItemNameType(this.statename);
            create_noti.message =(item.name)? `${message_part} ${item_name} ${item.name}` : `${message_part} ${item_name} ${item.id}`;
            create_noti.committed_item_type = item_type;
            create_noti.committed_item_id = item.id;
            console.log(create_noti);
            axios.post('/admin/notifications/addnotification', create_noti).then(({data}) => {
                console.log('notification added successfully');
            }).catch(error => {
                console.log('error in notificationHandler');
                console.log(error.response);
            });
            this.lastrecord('notifications');
        },
        receive_noti(event) {
            this.lastrecord('notifications');
            let item_id = event.message.committed_item_id;
            let item_state_name = this.readStateName(event.message.committed_item_type);
            switch(event.message.noti_type){
                case 'admin_create' : if(this.$store.state[item_state_name].length > 0) this.lastrecord(item_state_name);break;
                case 'admin_edit' : if(this.$store.state[item_state_name].length > 0) this.replacerecord(item_state_name,item_id);break;
                case 'admin_delete' : this.deleterecord(item_state_name,item_id);break;
            }
            console.log('noti_receive_completed');
        },
        readStateName(type){
            switch(type){
                case 'App\\Admin': return 'admins';
                case 'App\\Book': return 'books';
                case 'App\\Author': return 'authors';
                case 'App\\Tag': return 'tags';
                case 'App\\Category':  return 'categories';
                case 'App\\Supplier': return 'suppliers';
                case 'App\\Publisher': return 'publishers';
                case 'App\\Comment': return 'comments';
            }
        },
        getItemNameType(name){
            switch(name){
                case 'admins' : return { item_name: 'admin', item_type: 'App\\Admin'};
                case 'books': return { item_name: 'book', item_type: 'App\\Book' };
                case 'authors': return { item_name: 'author', item_type: 'App\\Author' };
                case 'tags': return { item_name: 'tag', item_type: 'App\\Tag' };
                case 'categories': return { item_name: 'category', item_type: 'App\\Category' };
                case 'suppliers': return { item_name: 'supplier', item_type: 'App\\Supplier' };
                case 'publishers': return { item_name: 'publisher', item_type: 'App\\Publisher' };
                case 'comments': return { item_name: 'comment', item_type: 'App\\Comment' };
            }
        }
    }
}