<template>
    <div style="height:50vh;overflow-y:scroll">
        <div v-if="myStore.length > 0">
            <div v-for="(drugs, index) in myStore" :key="drugs.id" class="card card-body mt-1">
                <div style="display:flex;flex-direction:row;justify-content:space-between">
                    <p class="mr-1" style="color:black;width:50%;font-weight:bold">{{ index+1 }}) {{ drugs.name }}</p>
                    <p @click="viewDrug(drugs.id)" class="view"><i class="fa fa-eye"></i> View</p>
                    <p @click="deleteDrug(drugs.name,drugs.id)" class="delete"><i class="fa fa-trash"></i> Delete</p>
                </div>
                <p @click="sellDrug(drugs.name,drugs.id,drugs.hcpi,drugs.drug_type,drugs.price)" class="sell"><i class="fa fa-cart-plus"></i> Sell</p>
            </div>
        </div>
        <div v-else>
            <div v-if="isLoading" class="spinner-position spinner-border text-primary" style="height:3rem;width:3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div v-if="empty">
                <p class="empty-store-info">
                    <i class="fa fa-info"></i>
                    Your Store looks empty
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import VendorDrugSearchEvent from './VendorDrugSearchEvent';
import SellDrugEvent from './SellDrugEvent';
export default {
    data(){
        return {
            myStore: [],
            url: 'http://127.0.0.1:8000/api/drug',
            counter: 1,
            token: '',
            isLoading: false,
            empty: false,
        }
    },
    props:['newDrug'],
    watch: {
        newDrug: function(newVal) {
            this.myStore.push(newVal);
        }
    },
    methods: {
        getAllVendorsDrugs(){
            this.isLoading = true;
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.myStore = res;
                this.isLoading = false;
                if(res.length < 1){
                    this.empty = true;
                }
            }).catch(err => {
                console.log(err)
            })
        },
        viewDrug(value){
            this.$emit('viewDrug',value);
        },
        deleteDrug(name,id){
            var result = confirm('Are you sure you want to delete '+name+' from your inventory?');
            if(result){
                axios.delete('http://127.0.0.1:8000/api/drug/'+id,config)
                .then(res => {
                    
                })
                .catch(err => {
                    console.log(err)
                })
                this.$store.commit('increment');
            }
        },
        sellDrug(value,id,hcpi,drug_type,price){
            SellDrugEvent.$emit('sell',value,id,hcpi,drug_type,price);
        }
    },
    mounted(){
        this.getAllVendorsDrugs();
    },
    created(){
        VendorDrugSearchEvent.$on('searching',(value) => {
            let search_url = 'http://127.0.0.1:8000/api/search?q='+value;
             this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            fetch(search_url,config)
            .then(res => res.json())
            .then(res => {
                if(res.length !== 0){
                    console.log(res);
                    this.myStore = res
                }
                else{
                    this.$noty.warning(value +' not found in your inventory');
                }
            })
            .catch(err => {
                console.log(err)
            })
        })
    }
}
</script>

<style scoped>
    .view {
        background-color: #2770c2;
        padding: 0px 8px;
        border-radius: 15px;
        width:25%;
        height:25px;
        cursor:pointer;
        font-size: 15px;
    }
    .delete {
        background-color: #d9534f;
        padding: 0px 8px;
        border-radius: 15px;
        width:25%;
        height:25px;
        cursor:pointer;
        font-size: 15px;
    }
    .sell {
        margin-bottom: 0px;
        background-color: #08b577;
        color: white !important;
        padding: 4px;
        font-size: bold;
        text-align: center;
        font-weight: bold;
        border-radius: 30px;
        cursor:pointer;
    }
    .empty-store-info {
        background-color: #abe6ab;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid green;
        font-weight: 900;
        border-radius:2px;
    }
    .spinner-position {
        position:relative;
        top:200px;
        left:43%;
    }
</style>