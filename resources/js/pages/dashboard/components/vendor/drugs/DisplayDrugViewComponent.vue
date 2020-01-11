<template>
  <div class="drug-container">
      <header>
          <h4>{{ drugDetails.name }}</h4>
          <p @click="emitCloseEvent()" id="close">&times;</p>
      </header>
      <div style="width:100%;display:flex;justify-content:space-between">
          <div style="width:29%">
              <DrugDetails v-bind:drugDetails="this.drugDetails" />
          </div>
          <div style="width:39%">
              
          </div>
          <div style="width:29%">
              <EditDrug v-bind:drugDetails="this.drugDetails" v-on:added="updateDrugDetails($event)" />
          </div>
      </div>
  </div>
</template>

<script>
var config = {
    headers: {
        'Authorization': "Bearer "+localStorage.getItem('token'),
    }
};
export default {
    data(){
        return {
            url: 'http://127.0.0.1:8000/api/drug/'+this.drugId,
            drugDetails:{},
            update: 0
        }
    },
    methods: {
        emitCloseEvent(){
            this.$emit('close');
        },
        getDrugDetails(){
            // fetch drug details
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.drugDetails = res;
            })
        },
        updateDrugDetails(value){
            this.drugDetails = value;
            this.$emit('added');
        }
    },
    created(){
        this.getDrugDetails()
    },
    props:['drugId']
}
</script>

<style scoped>
    .drug-container {
        background-color:white;
        position: absolute;
        width: 80%;
        height: 80vh;
        z-index: 2;
        box-shadow: 1px 1px 6px 1px #a09e9e;
    }
    header {
        background-color:#2770c2;
        display:flex;
        justify-content: space-between;
        padding: 5px 10px;
    }
    #close {
        font-weight: bold;
        font-size: 30px;
        margin-bottom: 0px;
        line-height: 27px;
        cursor:pointer;
    }
</style>