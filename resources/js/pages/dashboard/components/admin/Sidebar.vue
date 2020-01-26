<template>
  <div style="padding:10px">
      <ul>
          <li :id="(choosen === 'vendors')? 'selected' : 'unselected'" @click="choice('vendors')">
              <span style="margin-left: 10px;">
                  <i :id="(choosen === 'vendors')? 'select' : 'unselect'" class="fa fa-user-md"></i>
                  <span :id="(choosen === 'vendors')? 'select' : 'unselect'">Vendors</span>
              </span>
          </li>
      </ul>
      <ul>
          <li :id="(choosen === 'customers')? 'selected' : 'unselected'" @click="choice('customers')">
              <span style="margin-left: 10px;">
                  <i :id="(choosen === 'customers')? 'select' : 'unselect'" class="fa fa-user-o"></i>
                  <span :id="(choosen === 'customers')? 'select' : 'unselect'">Customers</span>
              </span>
          </li>
      </ul>
  </div>
</template>

<script>
export default {
    data(){
        return{
            choosen:'vendors',
        }
    },
    methods:{
        choice(value){
            // check what vendor clicked
            if(value === 'vendors'){
                this.choosen = 'vendors';
                this.emitEvent();
            }
            if(value === 'customers'){
                this.choosen = 'customers';
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