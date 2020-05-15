<template>
<div>
    <div class="toolbar">
        <div>
            <img class="logo" src="/images/logo.png">
            <h1>Welphat Admin Panel</h1>
        </div>    
    </div>
    <sidebar></sidebar>
</div>

</template>

<script>
import Sidebar from "./sidebar.vue"
export default {
    components: {
        Sidebar
    }
}
</script>

<style>
.toolbar {
    height: 8vh;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    border-bottom: 1px solid #e4e4e4;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
}

.toolbar .logo {
    height: 40px;
    display: inline-block;
    padding: 10px;
    margin-left: 20px;
    vertical-align: middle;
}
.toolbar h1 {
    display: inline-block;
    margin: 0px;    
    font-size: 20px;
    vertical-align: middle;
}
</style>