<template>
    <div>
        <div v-for="(drugs, index) in myStore" :key="drugs.id" style="display:flex;flex-direction:row;justify-content:space-between" class="card card-body mt-1">
            <p class="mr-1" style="color:black;width:50%">{{ index+1 }}) {{ drugs.name }}</p>
            <p @click="viewDrug(drugs.id)" class="view"><i class="fa fa-eye"></i> View</p>
            <p @click="deleteDrug(drugs.name,drugs.id)" class="delete"><i class="fa fa-trash"></i> Delete</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
var config = {
    headers: {
        'Authorization': "Bearer "+localStorage.getItem('token'),
    }
};
export default {
    data(){
        return {
            store: [],
            // url: 'http://127.0.0.1:8000/api/drug',
            counter: 1,
        }
    },
    // props:['newDrug'],
    // watch: {
    //     newDrug: function(newVal) {
    //         this.myStore.push(newVal);
    //     }
    // },
    methods: {
        // getAllVendorsDrugs(){
        //     fetch(this.url,config)
        //     .then(res => res.json())
        //     .then(res => {
        //         this.myStore = res;
        //     })
        // },
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
    // mounted(){
    //     this.getAllVendorsDrugs();
    // }
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
    }
    .delete {
        background-color: #d9534f;
        padding: 0px 8px;
        border-radius: 15px;
        width:25%;
        height:25px;
        cursor:pointer;
    }
</style>