<template>
  <div>
      <i id="search" class="fa fa-search"></i>
      <input style="padding-left:28px;position:relative" @keyup="searchDrug()" v-model="query" type="text" class="form-control" placeholder="Search drugs">
  </div>
</template>
<script>
import VendorDrugSearchEvent from './VendorDrugSearchEvent';
import _ from 'lodash';
export default {
    data(){
        return {
            query: ''
        }
    },
    methods: {
        searchDrug(){
            // console.log(this.query);
            VendorDrugSearchEvent.$emit('searching',this.query);
        }
    },
    created(){
        this.searchDrug = _.debounce(this.searchDrug,1000);
    }
}
</script>

<style>
    #search {
        color: grey;
        position: absolute;
        z-index: 1;
        line-height: 2.2em;
        padding-left: 10px;
    }
</style>