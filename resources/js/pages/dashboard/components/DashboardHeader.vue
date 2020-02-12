<template>
  <div>
      <header>
          <div id="home">
              <router-link to='/'>
                <h1><i class="fa fa-home"></i></h1>
              </router-link>
          </div>
          <div id="user-name">
              <span style="font-weight:900"  v-if="user.priviledges === 1" id="line-height" class="font-s"><i class="fa fa-user-circle-o"></i> Admin</span>  
              <span style="font-weight:900" v-if="user.priviledges === 2" id="line-height" class="font-s"><i class="fa fa-user-md"></i> Vendor</span>  
              <span style="font-weight:900" v-if="user.priviledges === 3" id="line-height" class="font-s"><i class="fa fa-user-o"></i> Customer</span>  
          </div>
          <nav>
              <ul>
                  <li>
                        <span class="font-s"><i class="fa fa-bell"></i></span>   
                  </li>
              </ul>
              <ul>
                  <li @click="logout()">    
                        <span class="font-s"><i class="fa fa-power-off"></i></span>
                  </li>
              </ul>
              <ul v-if="user.priviledges !== 3">
                  <li>    
                        <span class="font-s"><i class="fa fa-user"></i></span>
                  </li>
              </ul>
          </nav>
      </header>
  </div>
</template>
<style scoped>
    header {
        display:flex;
        justify-content: space-between;
        background-color: #2770c2;
        padding:0 20px;
    }
    .font-s {
        font-size:25px;
    }
    #home {
        width:30%;
    }
    #user-name {
        width:60%;
    }
    nav {
        display:flex;
        width: 6%;
        /* justify-content: space-between; */
    }
    ul {
        margin-bottom:0px;
        margin-right:10%;
        align-self: center;
    }
    ul li {
        list-style:none;
    }
    #login-button {
        padding: 10px;
        border: 1px solid white;
        border-radius: 2px;
    }
    #line-height {
        line-height: 53px;
    }
    #signup-button {
        padding: 10px;
        background-color:white;
        border-radius: 2px;
    }
</style>
<script>
export default {
    data(){
        return {
            token: '',
            url: '',
        }
    },
    props: ['user'],
    methods: {
        logout(){
            let choice = confirm('Are you sure you want to log out?');
            if(choice){
                this.token = localStorage.getItem('token');
                this.url = 'http://127.0.0.1:8000/api/logout';
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.chartData = res;
            });
                localStorage.removeItem('token');
                this.$router.push('/');
                this.$noty.info('Logged out successfully');
            }
        } 
    }
}
</script>