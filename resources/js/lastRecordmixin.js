export default {
    methods: {
        // Get latest data from database to state
        lastrecord(statename) {
            axios.get(`/api/admin/${statename}/lastrecord`).then(({ data }) => {
                this.$store.commit('addOneRecord', { route: statename, data })
            });
        }
    }
}