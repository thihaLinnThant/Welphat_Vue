export default {
  data() {
    return {
    }
  },
  methods: {
    lastrecord(statename) {
      if(statename === 'notifications'){
        axios.get(`/api/admin/${statename}/lastrecord`).then(({ data }) => {
          this.$store.commit('addOneRecord', { route: 'latest_notifications', data })
        }).catch(error => {
          console.log('got error in notifications lastrecord');
          console.log(error);
          console.log(error.response);
        });
      }
      axios.get(`/api/admin/${statename}/lastrecord`).then(({ data }) => {
        this.$store.commit('addOneRecord', { route: statename, data })
      }).catch(error => {
        console.log('got error in lastrecord');
        console.log(error);
        console.log(error.response);
      });
    },
    returnLastrecord(statename){
      return axios.get(`/api/admin/${statename}/lastrecord`).then(({data}) => { return data});
    },
    replacerecord(statename,id) {
      axios.get(`/api/admin/${statename}/onerecord/${id}`).then(({ data }) => {
        this.$store.commit('replaceOneRecord', { route: statename, data, id });
      }).catch(error => {
        console.log('got error in replacerecord');
        console.log(error);
        console.log(error.response);
      });
    },
    deleterecord(statename,id) {
      axios.post(`/admin/${statename}/delete/${id}`).then(response => {
        this.$store.commit('deleteOneRecord', { route: statename, id });
      }).catch(error => {
        console.log('got error in deleterecord');
        console.log(error);
        console.log(error.response);
      });
    }
  }
}