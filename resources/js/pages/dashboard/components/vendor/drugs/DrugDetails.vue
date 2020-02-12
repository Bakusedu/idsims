<template>
    <div style="padding:5px;overflow-y:auto;height:63vh">
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Photo</p>
            <p style="color:black;width:40%">
                <img :src="'http://127.0.0.1:8000/images/'+drugDetails.photo" class="img-fluid" alt="">
            </p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Company</p>
            <p style="color:black;width:40%">{{ drugDetails.company }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Price</p>
            <p style="color:black;width:40%">&#8358; {{ drugDetails.price }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Drug type</p>
            <p v-if="drugDetails.drug_type === 1" style="color:black;width:40%">Satchet</p>
            <p v-if="drugDetails.drug_type === 2" style="color:black;width:40%">Counting</p>
            <p v-if="drugDetails.drug_type === 3" style="color:black;width:40%">Syrup</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Quantity in stock</p>
            <p style="color:black;width:40%">{{ drugDetails.qty }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Active ingredients</p>
            <p style="color:black;width:40%">{{ drugDetails.active_ingredients }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Drug effects</p>
            <p style="color:black;width:40%">{{ drugDetails.effects }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Cures</p>
            <p style="color:black;width:40%">{{ drugDetails.cure }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Drug interaction</p>
            <p style="color:black;width:40%">{{ drugDetails.interaction }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Overdose</p>
            <p style="color:black;width:40%">{{ drugDetails.overdose }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Dosage</p>
            <p style="color:black;width:40%">{{ drugDetails.dosage }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Note</p>
            <p style="color:black;width:40%">{{ drugDetails.note }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Hcpi</p>
            <p v-if="drugDetails.hcpi === 5" style="background-color:#e15361;text-align:center;width:40%;border-radius:20px">High</p>
            <p v-if="drugDetails.hcpi === 2" style="background-color:#ffc20d;text-align:center;width:40%;border-radius:20px">Moderate</p>
            <p v-if="drugDetails.hcpi === 0" style="background-color:#7d858c;text-align:center;width:40%;border-radius:20px">Low</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Nafdac reg no</p>
            <p style="color:black;width:40%">{{ drugDetails.nafdac }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Expiry date</p>
            <p style="color:black;width:40%">{{ drugDetails.expiry_date }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props:['drugDetails'],
    data(){
        return {
            
        }
    }
}
</script>

<style>

</style>