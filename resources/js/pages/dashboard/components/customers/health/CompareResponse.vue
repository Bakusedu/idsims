<template>
    <div>
        <div v-if="spinner">
            <div class="spinner-position spinner-border text-primary" style="height:3rem;width:3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <table v-if="display" class="table table-responsive mt-2">
                <thead>
                    <tr>
                    <th style="color:black" scope="col">#</th>
                    <th style="color:black" scope="col">Drug name</th>
                    <th style="color:black" scope="col">Company</th>
                    <th style="color:black" scope="col">Price</th>
                    <th style="color:black" scope="col">Shop name</th>
                    <th style="color:black" scope="col">Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(drug,index) in drugs" v-bind:key="drug.index">
                    <th style="color:black" scope="row">{{ index+1 }}</th>
                    <td style="color:black">{{ drug.name }}</td>
                    <td style="color:black">{{ drug.company }}</td>
                    <td style="color:black">&#8358;{{ drug.price }}</td>
                    <td style="color:black">{{ drug.store_name }}</td>
                    <td style="color:black">{{ drug.address }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import SearchEventQuery from './SearchEventQuery';
export default {
    data(){
        return {
            token: '',
            spinner: false,
            url: '',
            drugs:[],
            display: false,
        }
    },
    created(){
        SearchEventQuery.$on('compare', (value) => {
            this.spinner = true;
            this.token = localStorage.getItem('token');
            this.url = 'http://127.0.0.1:8000/api/compare_drug/'+value;
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.spinner = false;
                this.display = true;
                this.drugs = res;
            }).catch(err => {
                this.$noty.error('Search query failed.');
                this.spinner = false;
            })
        });
    }
}
</script>

<style>
    .spinner-position {
        position:relative;
        top:20px;
        left:43%;
    }
</style>