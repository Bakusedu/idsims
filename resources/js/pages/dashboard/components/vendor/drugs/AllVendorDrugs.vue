<template>
    <div style="height:50vh;overflow-y:scroll">
        <div v-for="(drugs, index) in myStore" :key="drugs.id" class="card card-body mt-1">
            <div style="display:flex;flex-direction:row;justify-content:space-between;height:32px;">
                <p class="mr-1" style="color:black;width:50%">{{ index+1 }}) {{ drugs.name }}</p>
                <p @click="viewDrug(drugs.id)" class="view"><i class="fa fa-eye"></i> View</p>
                <p @click="deleteDrug(drugs.name,drugs.id)" class="delete"><i class="fa fa-trash"></i> Delete</p>
            </div>
            <p class="sell">Sell</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import VendorDrugSearchEvent from './VendorDrugSearchEvent';
var config = {
    headers: {
        'Authorization': "Bearer "+localStorage.getItem('token'),
        'Accept':'application/json'
    }
};
export default {
    data(){
        return {
            myStore: [],
            url: 'http://127.0.0.1:8000/api/drug',
            counter: 1,
            token: ''
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
        }
    },
    mounted(){
        this.getAllVendorsDrugs();
    },
    created(){
        VendorDrugSearchEvent.$on('searching',(value) => {
            let search_url = 'http://127.0.0.1:8000/api/search?q='+value;
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
        background-color: green;
        color: white !important;
        padding: 4px;
        font-size: bold;
        text-align: center;
        font-weight: bold;
        border-radius: 30px;
        cursor:pointer;
    }
</style>