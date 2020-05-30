export default {
    methods: {
        lastrecord(routename, statename) {
            axios.get(`/api/lastrecord/${routename}`).then(({ data }) => {
                this.$store.commit('addOneRecord', { route: statename, data })
            });
        }
    }
}