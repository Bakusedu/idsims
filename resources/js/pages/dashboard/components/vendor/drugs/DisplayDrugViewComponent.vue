<template>
  <div class="drug-container">
      <header>
          <h4>{{ drugDetails.name }}</h4>
          <p @click="emitCloseEvent()" id="close">&times;</p>
      </header>
      <div  style="width:100%;display:flex;justify-content:space-between">
        <div v-if="isLoading" class="spinner-position spinner-border text-primary" style="height:3rem;width:3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
          <div v-else style="width:29%">
              <DrugDetails v-bind:drugDetails="this.drugDetails" />
          </div>
          <div style="width:39%">
              <DrugPurchaseFrequency v-bind:name="this.drugDetails.name" v-bind:qty="this.qty" v-bind:error="this.error"/>
          </div>
          <div style="width:29%">
              <EditDrug v-bind:drugDetails="this.drugDetails" v-on:added="updateDrugDetails($event)" />
          </div>
      </div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            url: 'http://127.0.0.1:8000/api/drug/'+this.drugId,
            purchase_url: 'http://127.0.0.1:8000/api/drug_purchase/'+this.drugId,
            drugDetails:{},
            update: 0,
            error: '',
            qty:0,
            isLoading: false,
        }
    },
    methods: {
        emitCloseEvent(){
            this.$emit('close');
        },
        getDrugDetails(){
            this.token = localStorage.getItem('token');
            this.isLoading = true;
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            // fetch drug details

            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.isLoading = false;
                this.drugDetails = res;
            })
        },
        getDrugPurchaseDetails(){
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            // fetch drug details
            fetch(this.purchase_url,config)
            .then(res => res.json())
            .then(res => {
                if(res.error){
                    this.error = res.error;
                }
                else {
                    this.qty = res;
                }
            })
        },
        updateDrugDetails(value){
            this.drugDetails = value;
            this.$emit('added');
        }
    },
    created(){
        this.getDrugDetails()
        this.getDrugPurchaseDetails();
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
    .spinner-position {
        position:relative;
        top:200px;
        left:10%;
    }
</style>