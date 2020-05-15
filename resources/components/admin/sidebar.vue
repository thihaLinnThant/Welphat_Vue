<template>
  <div class="sidebar">
    <div class="main-navText" :collapse='true'>
      <i id="nav-btn" class="fas fa-bars" ></i> MAIN NAVIGATION
    </div>
    <div>
      <i class="fas fa-book"></i> Books
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Admins
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Users
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Authors
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Tags
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Categories
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Comments
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Publishers
    </div>
    <div>
      <i class="fas fa-user-shield"></i> Orders
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      collapse: true
    }
  },
  computed: {
    // collapse() {
    //   if(collapse == false) {
        
    //   }
    // }
  }

}
</script>

<style>
.sidebar {
  height: 92vh;
  width: 17vw;
  background-color: #374850;
  box-shadow: 5px 5px 5px 5px rgba(0, 0, 0, 0.1);
  transition: 0.5s ease-in-out;
}
/* .sidebar .collapse {  
} */
.main-navText{
  background: #222D32;    
  width: auto;
  padding: 3px;
  color: grey;
  font-size: 15px;
  line-height: 40px;
}
.main-navText i {
  vertical-align: middle;
  margin-right: 10px;
  margin-left: 10px;
  font-size: 20px;
}

</style>