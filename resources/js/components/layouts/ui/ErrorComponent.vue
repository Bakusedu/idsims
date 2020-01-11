<template>
  <div>
        <div class="error">
            <p v-for="error in errors" :key="error.index">{{ error }}</p>
        </div>
  </div>
</template>

<script>
export default {
    props:['errors']
}
</script>

<style>
    .error {
        background-color: #d9534f;
        padding: 5px;
        border-radius: 5px;
    }
    .error p {
        margin-bottom:0px;
    }
</style>