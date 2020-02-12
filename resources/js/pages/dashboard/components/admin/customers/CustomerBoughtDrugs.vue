<template>
  <div>
      <table style="height:60vh" v-if="purchases" class="table table-responsive mt-2">
            <thead>
                <tr>
                <th style="color:black" scope="col">#</th>
                <th style="color:black" scope="col">Drug name</th>
                <th style="color:black" scope="col">Qty</th>
                <th style="color:black" scope="col">Vendor name</th>
                <th style="color:black" scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(purchase,index) in purchases" :key="purchase.index">
                <th style="color:black" scope="row">{{ index+1 }}</th>
                <td style="color:black">{{ purchase[0] }}</td>
                <td style="color:black">{{ purchase[1] }}</td>
                <td style="color:black">{{ purchase[2] }}</td>
                <td style="color:black">{{ purchase[3]}}</td>
                </tr>
            </tbody>
        </table>
  </div>
</template>

<script>
import _ from 'lodash';
export default {
    data(){
        return {
            token: '',
            url: '',
            purchases: [],
            phone: null,
        }
    },
    props:['id'],
    methods: {
       getAllCustomerBoughtDrugs(){
            this.url = 'http://127.0.0.1:8000/api/customer/'+this.id;
            this.token = localStorage.getItem('token');
            let config = {
                    headers:{
                        'Authorization': "Bearer "+this.token
                    }
                }
                    fetch(this.url,config)
                     .then(res => res.json())
                     .then(res => {
                         if(res.message){
                    this.$noty.warning(res.message);
                }
                if(res.error){
                    this.$noty.error(res.error);
                }
                else{
                    let newArray = [];
                    let tempArray = [];
                    for(let i=0;i < res.drug_names.length; i++){
                        // newArray.push(res.drug_names[i],res.drug_qty[i]);
                        newArray[i] = res.drug_names[i]+','+res.drug_qty[i]+','+res.vendor_names[i]+','+res.time[i];
                    }
                    // this.customerHistory = newArray;
                    newArray.forEach(function(value){
                        tempArray.push(value.split(','));
                    })
                    this.purchases = tempArray;
                }
            });
        },
        // getUserPhone(){
        //      this.url = 'http://127.0.0.1:8000/api/user/'+this.id;
        //     this.token = localStorage.getItem('token');
        //     let config = {
        //             headers:{
        //                 'Authorization': "Bearer "+this.token
        //             }
        //         }
        //             fetch(this.url,config)
        //              .then(res => res.json())
        //              .then(res => {
        //                  return res.phone;
        //         })
        // }
    },
    mounted(){
        this.getAllCustomerBoughtDrugs();
        
    },
}
</script>

<style>

</style>