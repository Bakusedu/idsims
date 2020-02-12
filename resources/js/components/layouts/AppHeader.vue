<template>
  <div>
      <header>
          <div>
              <h3 class="mb-0 line-height-2" style="font-weight:bolder">IDSIMS</h3>
          </div>
          <nav v-if="!name">
              <ul style="margin-right:10px;" class="line-height-2">
                  <li class="mt-1" id="login-button" @click="emitButtonEvent('login')">
                        <SmallButtonBlue>Login</SmallButtonBlue>    
                  </li>
              </ul>
              <ul class="line-height-2">
                  <li class="mt-1" id="signup-button" @click="emitButtonEvent('signup')">    
                        <SmallButtonWhite>Sign up</SmallButtonWhite>
                  </li>
              </ul>
          </nav>
          <nav v-else>
              <ul style="margin-right:10px;">
                  <router-link id="router-hover-effect" to="/dashboard">
                    <li class="mt-1">
                            <strong><span style="font-size:25px"><i class="fa fa-user"></i></span></strong>  
                    </li>
                  </router-link>
              </ul>
              <ul>
                  <li @click="logout()" class="mt-1">    
                        <strong><span style="font-size:25px"><i class="fa fa-power-off"></i></span></strong>
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
        background-color:#2770c2;
        padding:0px 20px;
    }
    #router-hover-effect:hover {
        text-decoration:none;
    }
    nav {
        display:flex;
        justify-content: space-between;
    }
    ul li {
        list-style:none;
    }
    #login-button {
        padding: 4px;
        border: 1px solid white;
        border-radius: 2px;
    }
    #signup-button {
        padding: 4px;
        background-color:white;
        border-radius: 2px;
    }
    .line-height-2 {
        line-height:2;
    }
</style>
<script>
export default {
    data(){
        return {

        }
    },
    props:['name'],
    methods : {
        emitButtonEvent(value) {
            if(value == 'login'){
                 this.$emit('form',value);
            }
            else {
                this.$emit('form',value);
            }
        },
        logout(){
            let choice = confirm('Are you sure you want to log out?');
            if(choice){
                localStorage.removeItem('token');
                location.reload();
                this.$noty.info('Logged out successfully');
            }
        }  
    }
}
</script>

<style>

</style>