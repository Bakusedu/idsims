<template>
  <div class="drug-container">
      <header>
          <h4 style="color:black">{{ drugName }}</h4>
          <p style="color:black" @click="emitCloseSell()" id="close">&times;</p>
      </header>
      <div style="width:100%;display:flex;justify-content:space-between">
          <div style="width:29%">
              <div class="d-flex" style="justify-content:space-between">
                <p style="color:black;width:40%;font-weight:900">Hcpi</p>
                <p v-if="hcpi === 5" style="background-color:#e15361;text-align:center;width:40%;border-radius:20px">High</p>
                <p v-if="hcpi === 2" style="background-color:#ffc20d;text-align:center;width:40%;border-radius:20px">Moderate</p>
                <p v-if="hcpi === 0" style="background-color:#7d858c;text-align:center;width:40%;border-radius:20px">Low</p>
            </div>
              <div class="d-flex" style="justify-content:space-between">
                <p style="color:black;width:40%;font-weight:900">Drug type</p>
                <p v-if="drug_type === 1" style="text-align:center;width:40%;color:black">Counting</p>
                <p v-if="drug_type === 2" style="text-align:center;width:40%;color:black">Satchet</p>
                <p v-if="drug_type === 3" style="text-align:center;width:40%;color:black">Syrup</p>
            </div>
            <form action="" @submit.prevent="registerPurchase()">
                <div style="display:flex;justify-content:space-between">
                    <div style="width:60%">
                        <label for="qty" style="color:black">Quantity</label>
                        <div class="form-group">
                            <input type="text" v-model="data.qty" class="form-control">
                        </div>
                    </div>
                    <div style="width:30%;position:relative">
                        <label for="total" style="color:black">Total</label>
                        <div class="form-group">
                            <span style="position:absolute;color:black;top:31px;left:10px;">&#8358;</span>
                            <p style="padding-left:25%;color:black">{{ this.data.qty * this.price }}</p>
                        </div>
                    </div>
                </div>
                <label for="qty" style="color:black">Phone number</label>
                <div style="display:flex">
                    <div class="form-group" style="width:80%">
                        <input type="text" style="border-top-right-radius: 0px;
                        border-bottom-right-radius: 0px;" required v-model="value" class="form-control" placeholder="Customers phone number">
                    </div>
                    <div class="check-button" @click="emitEvent()">
                        <p style="margin-bottom:0px; padding:8px;font-weight:bold">Check</p>
                    </div>

                </div>
                <BlockButtonGreen>
                    <i class="fa fa-cart-plus"> Sell drug</i>
                </BlockButtonGreen>
            </form>
            <div class="info mt-2">
                <p style="font-weight:900">In cases of medications with high hcpi, prescription from a medical practisioner should be sighted</p>
            </div>
          </div>
          <div style="width:39%">
              <CustomerPurchaseHistory v-bind:number="this.data.number" />
          </div>
          <div style="width:29%">
              <SignUpNewCustomer />
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    props:['drugId','drugName','hcpi','drug_type','price'],
    data(){
        return {
            url: 'http://127.0.0.1:8000/api/drug/'+this.drugId,
            drugDetails:{},
            update: 0,
            value:'',
            data:{
                number:'',
                qty:null,
                drug_id: null
            },
            customer:'',
        }
    },
    methods: {
        emitCloseEvent(){
            this.$emit('close');
        },
        emitCloseSell(){
            this.$emit('close_sell');
            this.value = '';
            this.data.number = '';
        },
        getDrugDetails(){
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            // fetch drug details
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.drugDetails = res;
            })
        },
        registerPurchase(){
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            this.data.number = this.value;
            this.data.drug_id = this.drugId;
            axios.post('http://127.0.0.1:8000/api/purchase',this.data,config)
            .then(res => {
                if(res.data.message){
                    this.$noty.success(res.data.message);
                }
                else{
                    this.$noty.error(res.data.error);
                }
                this.emitCloseSell();
            })
        },
        updateDrugDetails(value){
            this.drugDetails = value;
            this.$emit('added');
        },
        emitEvent(){
            this.data.number = this.value;
        }
    },
    created(){
        this.getDrugDetails();
    },
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
        padding: 20px 20px;
    }
    header {
        display:flex;
        justify-content: space-between;

    }
    #close {
        font-weight: bold;
        font-size: 30px;
        margin-bottom: 0px;
        line-height: 27px;
        cursor:pointer;
    }
    .info {
        background-color: #8f8fe8;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid blue;
    }
    .check-button {
        width: 20%;
        background-color: #08b577;
        height: 38px;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        cursor:pointer;
    }
</style>