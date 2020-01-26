<template>
<div>
  <DashboardHeader v-bind:user="user" />
  <div v-if="user">
    <DashboardContainer v-bind:user="user" />
  </div>
</div>
</template>

<script>
export default {
    data(){
      return {
        url:'http://127.0.0.1:8000/api/user',
        user:{},
        token:''
      }
    },
    methods: {
      getAuthenticatedUser(){
        this.token = localStorage.getItem('token');
        let config = {
          headers:{
            'Authorization': "Bearer "+this.token
          }
        }
        // fetch authenticated user details
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.user = res;
                
            })
      }
    },
    mounted(){
      this.getAuthenticatedUser();
    }
}
</script>

<style>

</style>