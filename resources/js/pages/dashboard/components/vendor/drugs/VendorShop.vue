<template>
  <div>
        <div v-if="display">
            <h4 style="color:black">My shop</h4>
            <div class="brick mt-2">
                <div class="image">
                    <img  v-if="picture" :src="'http://127.0.0.1:8000/images/'+picture" alt="" class="img-fluid">
                    <img v-else src="images/login.png" alt="" class="img-fluid">
                </div>
                <div class="vendor_info">
                    <h5 v-if="store_name" style="color:black;">{{ store_name }}</h5>
                    <p v-if="address" style="color:black">{{ address }}</p>
                    <h5 v-if="!store_name" style="color:black;">Shop name</h5>
                    <p v-if="!address" style="color:black">Address</p>
                </div>
                <div class="vendor_border">
                    <div class="vendor_details">
                        <span>
                            <i style="color:black" class="fa fa-user"></i>
                        </span>
                        <p v-if="name" style="color:black;display:inline-block">{{ name }}</p>
                        <p v-else style="color:black;display:inline-block">Vendor name</p>
                    </div>
                </div>
            </div>
        </div>
  </div>
</template>

<script>
export default {
    data(){
        return {
            token: '',
            url: 'http://127.0.0.1:8000/api/vendor_settings',
            name: '',
            store_name: '',
            address: '',
            picture: '',
            display:false,
        }
    },
    methods: {
        fetchVendorShopDetails(){
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token,
                }
            }
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                if(res.settings){
                    this.name = res.user;
                    this.store_name = res.settings.store_name;
                    this.address = res.settings.address;
                    this.picture = res.settings.picture;
                    this.display = true;
                }
                else {
                    this.$noty.info(res.error);
                    this.display = true;
                }
            })

        }
    },
    mounted(){
        this.fetchVendorShopDetails();
    }
}
</script>

<style scoped>
    .brick {
        border-radius: 20px;
        overflow: hidden;
        background-color: #fff;
        width: 100%;
        height: 100%;
        transition: all .2s ease-out;
        box-shadow: 0 2px 43px -4px rgba(0,0,0,.19);
        display: flex;
        flex-direction: column;
    }
    .brick:hover {
        box-shadow: none;
        border:1px solid lightgrey;
        box-shadow: 0 2px 6px 1px rgba(0,0,0,.19);
    }
    .vendor_info {
        padding: 19px 20px 13px;
        min-height: 110px;
    }
    .vendor_details {
        padding:5px 20px 10px 20px;
    }
    .vendor_border {
        border-top:1px solid lightgrey;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
</style>