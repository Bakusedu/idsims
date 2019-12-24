<template>
  <div>
      <button class="btn-blue">
          <slot></slot>
      </button>
  </div>
</template>
<style>
    .btn-blue {
        background-color:#2770c2;
        width:100%;
        border: none;
        padding: 5px;
        border-radius: 5px;
        outline: none;
    }
</style>
<script>
export default {
    
}
</script>