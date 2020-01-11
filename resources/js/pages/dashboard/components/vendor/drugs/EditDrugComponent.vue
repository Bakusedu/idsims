<template>
    <div>
        <h5 style="color:black"><i style="color:black" class="fa fa-edit"></i> Edit Drug</h5>
        <EditDrugForm v-on:added="emitEvent($event)" v-bind:drugDetails="this.drugDetails"/>
    </div>
</template>

<script>
export default {
    props:['drugDetails'],
    data(){
        return {

        }
    },
    methods: {
        emitEvent(value){
            this.$emit('added',value);
        }
    }
}
</script>

<style>

</style>