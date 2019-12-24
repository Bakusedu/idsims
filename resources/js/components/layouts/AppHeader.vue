<template>
  <div>
      <header>
          <div>
              <h1>IDSIMS</h1>
          </div>
          <nav>
              <ul style="margin-right:10px;">
                  <li id="login-button" @click="emitButtonEvent('login')">
                        <SmallButtonBlue>Login</SmallButtonBlue>    
                  </li>
              </ul>
              <ul>
                  <li id="signup-button" @click="emitButtonEvent('signup')">    
                        <SmallButtonWhite>Sign up</SmallButtonWhite>
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
    }
    nav {
        display:flex;
        justify-content: space-between;
    }
    ul li {
        list-style:none;
    }
    #login-button {
        padding: 10px;
        border: 1px solid white;
        border-radius: 2px;
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

        }
    },
    methods : {
        emitButtonEvent(value) {
            if(value == 'login'){
                 this.$emit('form',value);
            }
            else {
                this.$emit('form',value);
            }
        }  
    }
}
</script>

<style>

</style>