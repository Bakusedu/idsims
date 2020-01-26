<template>
  <div>
      <div v-if="user_name">
        <p style="color:black"><span style="font-weight:900;color:black">{{ user_name }}'s</span> recent purchase history</p>
      </div>
      <div v-else class="info">
          <p style="color:black;margin-bottom:0px">Type a customers phone number to get their OTC purchase histories</p>
      </div>
      <table v-if="user_name" class="table table-responsive mt-2">
            <thead>
                <tr>
                <th style="color:black" scope="col">#</th>
                <th style="color:black" scope="col">Drug name</th>
                <th style="color:black" scope="col">Qty</th>
                <th style="color:black" scope="col">Vendor</th>
                <th style="color:black" scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(history,index) in customerHistory" :key="history.index">
                <th style="color:black" scope="row">{{ index+1 }}</th>
                <td style="color:black">{{ history[0] }}</td>
                <td style="color:black">{{ history[1] }}</td>
                <td style="color:black">{{ history[2] }}</td>
                <td style="color:black">{{ history[3] }}</td>
                </tr>
            </tbody>
        </table>
  </div>
</template>

<script>
export default {
    data(){
        return {
            token:'',
            // user_name: '',
            count:0,
            user_name:'',
            customerHistory: [],
            message: ''
        }
    },
    props:['number'],
    watch: {
        number: function(value){
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            let url = 'http://127.0.0.1:8000/api/customer/'+value;
            fetch(url,config)
            .then(res => res.json())
            .then(res => {
                // this.user_name = res.name;
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
                    this.customerHistory = tempArray;
                    this.user_name = res.user.name;
                }
                
            })
        }
    }
}
</script>

<style scoped>
    .info {
        background-color: #ecbd67;
        padding: 10px;
        border: 1px solid orange;
        border-radius: 4px;
        font-weight: bold;
    }
</style>