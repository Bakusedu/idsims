<template>
  <div>
      <button class="btn-green">
          <slot></slot>
      </button>
  </div>
</template>
<style scoped>
    .btn-green {
        background-color:#08b577;
        width:100%;
        border: none;
        padding: 5px;
        border-radius: 5px;
        outline: none;
    }
</style>