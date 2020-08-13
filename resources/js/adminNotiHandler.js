import Lastrecord from './lastRecordmixin';
export default{
    mixins: [Lastrecord],
    methods: {
        create_admin_noti(type, item){
            var create_noti = {};
            create_noti.noti_type = 'admin_' + type;
            create_noti.committer_id = window.current_admin.id;
            create_noti.committer_type = 'App\\Admin';
            
            var message_part;
            switch(type){
                case 'create': message_part = 'created ';break;
                case 'edit': message_part = 'made changes to ';break;
                case 'delete': message_part = 'deleted ';break;
            }

            switch(this.statename){
                case 'admins':
                        create_noti.message = message_part + 'admin id ' + item.id;
                        create_noti.committed_item_type = 'App\\Admin';
                    break;
                case 'books': 
                        create_noti.message = message_part + 'book id ' + item.id;
                        create_noti.committed_item_type = 'App\\Book';
                    break;
                case 'tags': 
                        create_noti.message = message_part + 'tag id ' + item.id;
                        create_noti.committed_item_type = 'App\\Tag';
                    break;
                case 'categories': 
                        create_noti.message = message_part + 'category id ' + item.id;
                        create_noti.committed_item_type = 'App\\Category';
                    break;
                case 'suppliers': 
                        create_noti.message = message_part + 'supplier id ' + item.id;
                        create_noti.committed_item_type = 'App\\Supplier';
                    break;
                case 'publishers': 
                        create_noti.message = message_part + 'publisher id ' + item.id;
                        create_noti.committed_item_type = 'App\\Publisher';
                    break;
                case 'comments': 
                    create_noti.message = message_part + 'comment id ' + item.id;
                    create_noti.committed_item_type = 'App\\Comment';
                break;
            }
            create_noti.committed_item_id = item.id;
            console.log(create_noti);
            axios.post('/admin/notifications/addnotification', create_noti).then(({data}) => {
                console.log('notification added successfully');
            }).catch(error => {
                console.log(error.response);
            });
        },
        receive_noti(event) {
            this.lastrecord('notifications');
            let item_id = event.message.committed_item_id;
            switch(event.message.committed_item_type){
                case 'App\\Admin':
                        switch(event.message.noti_type){
                            case 'admin_create' : this.lastrecord('admins');break;
                            case 'admin_edit' : this.$store.commit('replaceOneRecord', { route: 'admins', data, id });break;
                            case 'admin_delete' : this.$store.commit('deleteOneRecord', { route: 'admins', item_id });break;
                        }
                    break;
                case 'App\\Book':
                        this.lastrecord('books');
                    break;
                case 'App\\Tag':
                        this.lastrecord('tags');
                    break;
                case 'App\\Category': 
                        this.lastrecord('categories');
                    break;

                case 'App\\Supplier':
                        this.lastrecord('suppliers');
                    break;
                case 'App\\Publisher':
                        this.lastrecord('publishers');
                    break;
                case 'App\\Comment':
                        this.lastrecord('comments');
                    break;
            }
        }
    }
}