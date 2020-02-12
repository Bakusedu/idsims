<template>
  <div>
      <table style="height:50vh;overflow-y:scroll" class="table table-responsive table-bordered mt-2">
            <thead>
                <tr>
                <th style="color:black" scope="col">#</th>
                <th style="color:black" scope="col">Name</th>
                <th style="color:black" scope="col">Busines name</th>
                <th style="color:black" scope="col">Phone number</th>
                <th style="color:black" scope="col">Address</th>
                <th style="color:black" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(vendor,index) in vendors" v-bind:key="vendor.index">
                <th style="color:black">{{ index+1 }}</th>
                <td style="color:black">{{ vendor.name }}</td>
                <td style="color:black">{{ vendor.store_name }}</td>
                <td style="color:black">{{ vendor.phone }}</td>
                <td style="color:black">{{ vendor.address }}</td>
                <td>
                    <span @click="emitVendorView(vendor.name,vendor.store_id)" class="btn btn-primary mb-1">
                        <i class="fa fa-eye"></i>
                    </span>
                    <span  @click="toggleActivation(vendor.store_id)" :class="vendor.status === 0 ?'btn btn-success btn-disabled mb-1':'btn btn-success mb-1'">
                        <i class="fa fa-bullhorn"></i>
                    </span>
                    <span @click="toggleActivation(vendor.store_id)" :class="vendor.status === 1 ?'btn btn-danger btn-disabled':'btn btn-danger'">
                        <i class="fa fa-user-times"></i>
                    </span>
                    <span v-if="!vendor.viewed" class="badge badge-secondary">New</span>
                </td>
                </tr>
            </tbody>
        </table>
        <div class="info">
            <p style="font-weight:900">
                These are list of vendors that have their shop profile already setup
            </p>
        </div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            token: '',
            url: '',
            vendors: [],
            status: '',
        }
    },
    methods: {
        fetchAllVendors(){
            this.url = 'http://127.0.0.1:8000/api/vendors';
            this.token = localStorage.getItem('token');
            let config = {
                    headers:{
                        'Authorization': "Bearer "+this.token
                    }
                }
                    fetch(this.url,config)
                     .then(res => res.json())
                     .then(res => {
                         this.vendors = res.vendors;
                });
        },
        emitVendorView(name,id){
            this.$emit('open-vendor-view',name,id);
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
        this.fetchAllVendors();
    }
}
</script>

<style scoped>
    .info {
        background-color: #8f8fe8;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid blue;
    }
    .btn-disabled {
        background-color: #949e94;
    }
</style>