<template>
  <div>
      <table style="height:60vh" v-if="purchases" class="table table-responsive mt-2">
            <thead>
                <tr>
                <th style="color:black" scope="col">#</th>
                <th style="color:black" scope="col">Drug name</th>
                <th style="color:black" scope="col">Qty</th>
                <th style="color:black" scope="col">Customer</th>
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
export default {
    data(){
        return {
            token: '',
            url: '',
            purchases: [],
        }
    },
    props:['vendor_id'],
    methods: {
        getAllVendorSoldDrugs(){
            this.url = 'http://127.0.0.1:8000/api/vendor_purchases/'+this.vendor_id;
            this.token = localStorage.getItem('token');
            let config = {
                    headers:{
                        'Authorization': "Bearer "+this.token
                    }
                }
                    fetch(this.url,config)
                     .then(res => res.json())
                     .then(res => {
                         if(res.purchases.length > 0){
                            this.purchases = res.purchases;
                         }
                         else{
                             this.$noty.info('Vendor has no purchase history');
                         }
                });
        },
    },
    mounted(){
        this.getAllVendorSoldDrugs();
    }
}
</script>

<style>

</style>