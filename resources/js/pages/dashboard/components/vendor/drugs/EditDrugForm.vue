<template>
   <div>
        <div v-if="this.errorArray.length > 0">
            <ErrorComponent v-bind:errors = "this.errorArray"/>
        </div>
        <form @submit.prevent="updateDrug" method="POST" enctype="multipart/form-data" style="overflow-y:scroll;height:50vh">
            @csrf
            <div class="form-group">
                <label for="">Drug name</label>
                <input type="text" name="name" v-model="drug.name" class="form-control">
            </div>
            <div style="display:flex;justify-content:space-between">
                <div class="form-group width-45">
                    <label for="">Company name</label>
                    <input type="text" name="company" v-model="drug.company" class="form-control">
                </div>
                <div class="form-group width-45" style="position:relative">
                    <label for="">Price</label>
                    <span style="position:absolute;color:black;top:40px;left:10px;">&#8358;</span>
                    <input type="text" name="price" v-model="drug.price" class="form-control" style="padding-left:25px;">
                </div>
            </div>
            <div class="form-group">
                <label for="">Drug photo</label>
                <input type="file" style="border:none" name="image" class="form-control" @change="OnChangeFile($event)">
            </div>
            <div class="border-red">
                <div class="form-group">
                        <label for="">Active ingredients</label>
                        <input type="text" name="active_ingredients" v-model="drug.active_ingredients" class="form-control">
                    </div>
                <div class="form-group">
                    <label for="">What does this drug cure?</label>
                    <textarea name="cure" v-model="drug.cure" id="" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Drug effects</label>
                    <textarea name="effects" v-model="drug.effects" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Drug interactions</label>
                    <textarea name="interactions" v-model="drug.interaction" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Overdose</label>
                    <textarea name="overdose" v-model="drug.overdose" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Dosage</label>
                    <textarea name="dosage" v-model="drug.dosage" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Note</label>
                    <textarea name="note" v-model="drug.note" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <div class="form-group width-45">
                        <label for="">Drug quantity</label>
                        <input type="text" v-model="drug.qty" name="quantity" class="form-control">
                    </div>
                    <div class="form-group width-45">
                        <label for="">Drug type</label><br>
                        <label class="checkbox-inline pr-2"><input type="checkbox" @change="disableUnCheckedDrugTypes('satchet')" :disabled = disableSatchet name="satchet" v-model="drug_type.satchet">Satchet</label>
                        <label class="checkbox-inline"><input type="checkbox" @change="disableUnCheckedDrugTypes('counting')" :disabled = disableCounting name="counting" v-model="drug_type.counting">Counting</label>
                        <label class="checkbox-inline"><input type="checkbox" @change="disableUnCheckedDrugTypes('syrup')" :disabled = disableSyrup name="syrup" v-model="drug_type.syrup">Syrup</label>
                    </div>
            </div>
            <div class="form-group">
                <label for="">Health care proffessional involvement in drug dosage</label>
                <label class="checkbox-inline pr-2"><input type="checkbox" @change="disableUnCheckedHcpi('low')" :disabled = disableLow name="low" v-model="hcpi.low" value="0">Low</label>
                <label class="checkbox-inline pr-2"><input type="checkbox" @change="disableUnCheckedHcpi('moderate')" :disabled = disableModerate name="moderate" v-model="hcpi.moderate" value="2">Moderate</label>
                <label class="checkbox-inline"><input type="checkbox" @change="disableUnCheckedHcpi('high')" :disabled = disableHigh name="high" v-model="hcpi.high" value="5">High</label>
            </div>
            <div class="form-group">
                <label for="">Nafdac registration number</label>
                <input type="text" v-model="drug.nafdac" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Expiry date</label>
                <input type="text" v-model="drug.expiry_date" class="form-control">
            </div>
            <BlockButtonGreen>Update drug</BlockButtonGreen>
            </div>
        </form>
   </div>
</template>

<script>
import axios from 'axios';
export default {
    props:['drugDetails'],
    data(){
        return {
            drug: {
                name: '',
                company: '',
                price: '',
                active_ingredients: '',
                cure: '',
                effects: '',
                interactions: '',
                overdose: '',
                dosage: '',
                note: '',
                qty: '',
                drug_type: '',
                nafdac:'',
                expiry_date:'',
                hcpi: 0,
                image: {}
            },
            temp_drug: {},
            drug_type: {
                satchet: false,
                counting: false,
                syrup: false
            },
            hcpi: {
                low:false,
                moderate:false,
                high:false
            },
            token:'',
            disableSatchet:false,
            disableCounting:false,
            disableSyrup:false,
            disableLow:false,
            disableModerate:false,
            disableHigh:false,
            url: '',
            errorArray:[],
            temp_errors:[],
        }
    },
    watch: {
        drugDetails: function(newVal) {
            this.drug.name = newVal.name
            this.drug.company = newVal.company
            this.drug.price = newVal.price
            this.drug.active_ingredients = newVal.active_ingredients
            this.drug.cure = newVal.cure
            this.drug.effects = newVal.effects
            this.drug.interaction = newVal.interaction
            this.drug.overdose = newVal.overdose
            this.drug.dosage = newVal.dosage
            this.drug.note = newVal.note
            this.drug.qty = newVal.qty
            this.drug.nafdac = newVal.nafdac
            this.drug.expiry_date = newVal.expiry_date
            if(newVal.drug_type === 1){
                this.disableUnCheckedDrugTypes('satchet')
                this.drug_type.satchet = true
            }
            else if(newVal.drug_type === 2){
                this.disableUnCheckedDrugTypes('counting')
                this.drug_type.counting = true
            }
            else {
                this.disableUnCheckedDrugTypes('syrup')
                this.drug_type.syrup = true
            }
            if(newVal.hcpi === 0){
                this.disableUnCheckedHcpi('low')
                this.hcpi.low = true
            }
            else if(newVal.hcpi === 2){
                this.disableUnCheckedHcpi('moderate')
                this.hcpi.moderate = true
            }
            else {
                this.disableUnCheckedHcpi('high')
                this.hcpi.high = true
            }
            
            this.drug.image = newVal.photo
            this.url = 'http://127.0.0.1:8000/api/drug/'+newVal.id
        }
    },
    methods: {
        updateDrug(){
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token,
                    // "content-type": "multipart/form-data"
                }
            }
            this.assignHcpi();
            this.assignDrugType();
            this.temp_errors = [];
            this.output = '';
            this.errorArray = [];
            axios.patch(this.url,this.drug,config)
            .then(res => {
                this.$noty.success(res.data.message);
                this.drug = res.data.drug;
                this.$emit('added',this.drug);
            }).catch(err => {
                this.temp_errors.push(err.response.data.error);
                this.temp_errors.forEach(element => {

                    // this.errorArray.push(value);
                        if(element.name){
                            this.errorArray.push(element.name[0]);
                        }
                        if(element.company){
                            this.errorArray.push(element.company[0]);
                        }
                        if(element.price){
                            this.errorArray.push(element.price[0]);
                        }
                        if(element.cure){
                            this.errorArray.push(element.cure[0]);
                        }
                        if(element.qty){
                            this.errorArray.push(element.qty[0]);
                        }
                        if(element.drug_type){
                            this.errorArray.push(element.drug_type[0]);
                        }
                        if(element.hcpi){
                            this.errorArray.push(element.hcpi[0]);
                        }
                        if(element.dosage){
                            this.errorArray.push(element.dosage[0]);
                        }
                        if(element.active_ingredients){
                            this.errorArray.push(element.active_ingredients[0]);
                        }
                })
            })
                if(this.drug.hcpi === 0){
                    this.disableUnCheckedHcpi('low')
                }  
                if(this.drug.hcpi === 2){
                    this.disableUnCheckedHcpi('moderate')
                }  
                if(this.drug.hcpi === 5){
                    this.disableUnCheckedHcpi('high')
                } 
                if(this.drug.drug_type === 1){
                    this.disableUnCheckedDrugTypes('satchet')
                }  
                if(this.drug.drug_type === 2){
                    this.disableUnCheckedDrugTypes('counting')
                }  
                if(this.drug.drug_type === 3){
                    this.disableUnCheckedDrugTypes('syrup')
                } 
        },
        disableUnCheckedDrugTypes(value){
            if(value === 'satchet'){
                this.disableCounting = !this.disableCounting;
                this.disableSyrup = !this.disableSyrup;
            }
            if(value === 'counting'){
                this.disableSatchet = !this.disableSatchet;
                this.disableSyrup = !this.disableSyrup;
            }
            if(value === 'syrup'){
                this.disableCounting = !this.disableCounting;
                this.disableSatchet = !this.disableSatchet;
            }
        },
        disableUnCheckedHcpi(value){
            if(value === 'low'){
                this.disableModerate = !this.disableModerate;
                this.disableHigh = !this.disableHigh;
            }
            if(value === 'moderate'){
                this.disableLow = !this.disableLow;
                this.disableHigh = !this.disableHigh;
            }
            if(value === 'high'){
                this.disableLow = !this.disableLow;
                this.disableModerate = !this.disableModerate;
            }
        },
        assignHcpi(){
            if(this.hcpi.low){
                this.drug.hcpi = 0;
            }
            if(this.hcpi.moderate){
                this.drug.hcpi = 2;
            }
            if(this.hcpi.high){
                this.drug.hcpi = 5;
            }
        },
        assignDrugType(){
            if(this.drug_type.satchet){
                this.drug.drug_type = 1;
            }
            if(this.drug_type.counting){
                this.drug.drug_type = 2;
            }
            if(this.drug_type.syrup){
                this.drug.drug_type = 3;
            }
        },
        OnChangeFile(e){
            var fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);
            fileReader.onload = (e) => {
                this.drug.image = e.target.result;
            }
        },
    },
    mounted(){
        // this.fetchDrugItem();
    }
}
</script>

<style>
    .form-group label {
        color:black;
    }
</style>