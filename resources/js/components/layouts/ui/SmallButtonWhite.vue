<template>
  <div>
      <router-link class="btn-white" to="#">
          <slot></slot>
      </router-link>
  </div>
</template>

<script>
export default {
    
}
</script>

<style>
    .btn-white {
        text-decoration:none;
        color:#2770c2;
        font-weight:bold;
    }
    .btn-white:hover {
        text-decoration:none;
    }
</style>