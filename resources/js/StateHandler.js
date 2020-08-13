export default {
  data() {
    return {
    }
  },
  methods: {
    lastrecord(statename) {
      axios.get(`/api/admin/${statename}/lastrecord`).then(({ data }) => {
        this.$store.commit('addOneRecord', { route: statename, data })
      }).catch(error => {
        console.log('got error in statehandle');
        console.log(error);
        console.log(error.response);
      });
    },
    replacerecord(statename,id) {
      axios.get(`/api/admin/${statename}/onerecord/${id}`).then(({ data }) => {
        this.$store.commit('replaceOneRecord', { route: statename, data, id });
      }).catch(error => {
        console.log('got error in statehandle');
        console.log(error);
        console.log(error.response);
      });
    },
    deleterecord(statename,id) {
      axios.post(`/admin/${statename}/delete/${id}`).then(response => {
        this.$store.commit('deleteOneRecord', { route: statename, id });
      }).catch(error => {
        console.log('got error in statehandle');
        console.log(error);
        console.log(error.response);
      });
    }
  }
}