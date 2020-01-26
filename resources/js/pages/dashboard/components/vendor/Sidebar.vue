<template>
  <div style="padding:10px">
      <ul>
          <li :id="(choosen === 'My drugs')? 'selected' : 'unselected'" @click="choice('my drugs')">
              <span style="margin-left: 10px;">
                  <i :id="(choosen === 'My drugs')? 'select' : 'unselect'" class="fa fa-dashboard"></i>
                  <span :id="(choosen === 'My drugs')? 'select' : 'unselect'">My Drugs</span>
              </span>
          </li>
      </ul>
      <ul>
          <li :id="(choosen === 'Settings')? 'selected' : 'unselected'" @click="choice('settings')">
              <span style="margin-left: 10px;">
                  <i :id="(choosen === 'Settings')? 'select' : 'unselect'" class="fa fa-cog"></i>
                  <span :id="(choosen === 'Settings')? 'select' : 'unselect'">Settings</span>
              </span>
          </li>
      </ul>
  </div>
</template>

<script>
export default {
    data(){
        return{
            choosen:'My drugs',
        }
    },
    methods:{
        choice(value){
            // check what vendor clicked
            if(value === 'my drugs'){
                this.choosen = 'My drugs';
                this.emitEvent();
            }
            if(value === 'settings'){
                this.choosen = 'Settings';
                this.emitEvent();
            }
        },
        emitEvent(){
            this.$emit('choice',this.choosen);
        }
    },
    mounted(){
        this.emitEvent();
    }
}
</script>

<style>
    ul {
        margin-bottom:0px !important;
        cursor: pointer;

    }
    ul li {
        padding: 7px 0px;
        text-decoration:none;
    }
    #select {
        color:white !important;
    }
    #unselect {
        color:#2770c2 !important;
        font-weight:bold;
    }
    #selected {
        background-color:#2770c2;
        border-radius:5px;
        font-weight: bold;
    }
    #unselected {
        background-color: white;
    }
</style>