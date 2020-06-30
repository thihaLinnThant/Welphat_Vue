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
                this.$router.push(`/admin/books/${data.id}`)

                this.alertMessage = `${statename} (${data.name}) is registered with id - ${data.id}`;
            }).catch(error => {
                this.alertMessage = "Something went wrong!";

                console.log(error.response);
            })
        }
    }
}
