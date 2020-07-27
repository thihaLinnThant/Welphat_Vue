export default {
    data() {
        return {
            lastRecord: null
        }
    },
    methods: {
        // Get latest data from database to state
        lastrecord(statename) {
            axios.get(`/api/admin/${statename}/lastrecord`).then(({ data }) => {
                
                this.$store.commit('addOneRecord', { route: statename, data })
                this.lastRecord = data.name;
                if(statename == 'books'){
                    this.$router.push(`/admin/books/${data.id}`)
                }else if(statename == 'notifications'){
                    this.$store.commit('addOneRecord', { route: 'latest_notifications', data })
                }
                this.alertMessage = `${statename} (${data.name}) is registered with id - ${data.id}`;
                
                if(statename != 'notifications'){ this.create_admin_noti('create', this.target_item); }
            }).catch(error => {
                this.alertMessage = "Something went wrong!";

                console.log(error.response);
            })
        }
    }
}
