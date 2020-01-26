<template>
  <div>
      <div class="info">
          <p style="font-weight:900"><i style="color:white" class="fa fa-info"></i> Keep everyone up to date with your shop information</p>
      </div>
      <PostVendorSettings v-on:profile_updated="updateVendorProfile()" />
  </div>
</template>

<script>
export default {
    data(){
        return {

        }
    },
    methods: {
        updateVendorProfile(){
            this.$emit('profile_updated');
        }
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
</style>