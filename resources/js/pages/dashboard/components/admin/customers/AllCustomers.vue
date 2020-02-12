<template>
  <div>
      <table style="height:50vh;overflow-y:scroll" class="table table-responsive table-bordered mt-2">
            <thead>
                <tr>
                <th style="color:black" scope="col">#</th>
                <th style="color:black" scope="col">Name</th>
                <th style="color:black" scope="col">Email</th>
                <th style="color:black" scope="col">Phone no</th>
                <th style="color:black" scope="col">Address</th>
                <th style="color:black" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(customer,index) in customers" v-bind:key="customer.index">
                <th style="color:black">{{ index+1 }}</th>
                <td style="color:black">{{ customer.name }}</td>
                <td style="color:black">{{ customer.email }}</td>
                <td style="color:black">{{ customer.phone }}</td>
                <td style="color:black">{{ customer.address }}</td>
                <td>
                    <span @click="emitCustomerView(customer.name,customer.id)" class="btn btn-primary mb-1">
                        <i class="fa fa-eye"></i>
                    </span>
                    <span  @click="toggleActivation(customer.id)" :class="customer.status === 0 ?'btn btn-success btn-disabled mb-1':'btn btn-success mb-1'">
                        <i class="fa fa-bullhorn"></i>
                    </span>
                    <span @click="toggleActivation(customer.id)" :class="customer.status === 1 ?'btn btn-danger btn-disabled':'btn btn-danger'">
                        <i class="fa fa-user-times"></i>
                    </span>
                </td>
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
            customers: [],
        }
    },
    methods: {
        fetchAllCustomers(){
            this.url = 'http://127.0.0.1:8000/api/customers';
            this.token = localStorage.getItem('token');
            let config = {
                    headers:{
                        'Authorization': "Bearer "+this.token
                    }
                }
                    fetch(this.url,config)
                     .then(res => res.json())
                     .then(res => {
                         this.customers = res.customers;
                });
        },
        emitCustomerView(name,id){
            this.$emit('open-customer-view',name,id);
        },
        toggleActivation(id){
            this.url = "http://127.0.0.1:8000/api/toggle_status/"+id;
            this.token = localStorage.getItem('token');
            let config = {
                    headers:{
                        'Authorization': "Bearer "+this.token
                    }
                }
                    fetch(this.url,config)
                     .then(res => res.json())
                     .then(res => {
                         location.reload();
                });
        }
    },
    mounted(){
        this.fetchAllCustomers();
    }
}
</script>

<style scoped>
    .btn-disabled {
        background-color: #949e94;
    }
</style>