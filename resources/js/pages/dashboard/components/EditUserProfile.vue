<template>
    <div>
        <div style="box-shadow: 0 0 5px 1px #d2cccc;padding:20px;">
            <form @submit.prevent="updateUser()">
                <div v-if="this.errorArray.length > 0">
                    <ErrorComponent v-bind:errors = "this.errorArray"/>
                </div>
                <div v-if="this.output">
                    <div class="success">
                        <SuccessComponent v-bind:message = "this.output" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" v-model="data.name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" v-model="data.email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="text" v-model="data.phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Address</label>
                    <textarea name="" class="form-control" v-model="data.address" id="" cols="30" rows="3"></textarea>
                </div>
                <div>
                    <button class="btn-blue">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import UpdateUserEvent from './UpdateUserEvent';
var config = {
    headers: {
        'Authorization': "Bearer "+localStorage.getItem('token'),
    }
};
export default {
    data(){
            return {
                signup: false,
                data: {
                    phone: '',
                    address: '',
                    email: '',
                    name: ''
                },
                errorArray:[],
                temp_errors:[],
                output:'',
                url: 'http://127.0.0.1:8000/api/user/'+this.user.id
            }
        },
        props:['user'],
        methods: {
            assignValues(){
                this.data.name = this.user.name;
                this.data.email = this.user.email;
                this.data.phone = this.user.phone;
                this.data.address = this.user.address;
            },
            updateUser(){
                axios.put(this.url,this.data,config)
                .then(res => {    
                    this.data.name = res.data.name;
                    this.data.email = res.data.email;
                    this.data.phone = res.data.phone;
                    this.data.address = res.data.address;
                    UpdateUserEvent.$emit('updated',this.data);
                    this.$noty.success('Profile updated successfully!')
                }).catch(err => {
                    this.temp_errors.push(err.response.data.error);
                    this.temp_errors.forEach(element => {

                    // this.errorArray.push(value);
                        if(element.name){
                            this.errorArray.push(element.name[0]);
                        }
                        if(element.email){
                            this.errorArray.push(element.email[0]);
                        }
                        if(element.phone){
                            this.errorArray.push(element.phone[0]);
                        }
                        if(element.address){
                            this.errorArray.push(element.address[0]);
                        }
                })
            })
         }
        },
        mounted(){
            this.assignValues();
        }
}
</script>

<style>

</style>