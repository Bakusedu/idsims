<template>
  <div style="padding:10px">
      <ul>
          <li :id="(choosen === 'health')? 'selected' : 'unselected'" @click="choice('health')">
              <span style="margin-left: 10px;">
                  <i :id="(choosen === 'health')? 'select' : 'unselect'" class="fa fa-info"></i>
                  <span :id="(choosen === 'health')? 'select' : 'unselect'">Health Information</span>
              </span>
          </li>
      </ul>
      <ul>
          <li :id="(choosen === 'profile')? 'selected' : 'unselected'" @click="choice('profile')">
              <span style="margin-left: 10px;">
                  <i :id="(choosen === 'profile')? 'select' : 'unselect'" class="fa fa-user-o"></i>
                  <span :id="(choosen === 'profile')? 'select' : 'unselect'">Profile</span>
              </span>
          </li>
      </ul>
  </div>
</template>

<script>
export default {
    data(){
        return{
            choosen:'health',
        }
    },
    methods:{
        choice(value){
            // check what vendor clicked
            if(value === 'health'){
                this.choosen = 'health';
                this.emitEvent();
            }
            if(value === 'profile'){
                this.choosen = 'profile';
                this.emitEvent();
            }
        },
        emitEvent(){
            this.$emit('customer',this.choosen);
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