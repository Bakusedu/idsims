<template>
  <div>
      <router-link class="btn-blue" to="#">
          <slot></slot>
      </router-link>
  </div>
</template>
<style>
    .btn-blue {
        text-decoration:none;
        color:white;
        font-weight:bold;
    }
    .btn-blue:hover {
        text-decoration:none;
        color:white;
    }
</style>
<script>
export default {

}
</script>

<style>

</style>