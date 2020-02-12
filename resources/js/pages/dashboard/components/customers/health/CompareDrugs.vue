<template>
  <div style="display:flex;justify-content:space-between">
      <div>
        <input v-model="query" type="text" class="form-control" placeholder="Search drugs">
      </div>
      <div>
          <button @click="submit()" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
      </div>
  </div>
</template>
<script>
import SearchEventQuery from './SearchEventQuery';
export default {
    data(){
        return {
            query: ''
        }
    },
    methods: {
        submit(){
            SearchEventQuery.$emit('compare',this.query);
        }
    },
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