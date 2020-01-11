<template>
  <div>
      <header>
          <div id="home">
              <router-link to='/'>
                <h1><i class="fa fa-home"></i></h1>
              </router-link>
          </div>
          <div id="user-name">
              <span id="line-height" class="font-s">Hello, {{ user.name }}</span>  
          </div>
          <nav>
              <ul>
                  <li>
                        <span class="font-s"><i class="fa fa-bell"></i></span>   
                  </li>
              </ul>
              <ul>
                  <li>    
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

        }
    },
    props: ['user'],
}
</script>