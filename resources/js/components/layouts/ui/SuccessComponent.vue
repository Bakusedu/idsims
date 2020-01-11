<template>
  <div>
        <div class="success">
            <p>{{ message }}</p>
        </div>
  </div>
</template>

<script>
export default {
    props:['message']
}
</script>

<style>
    .success {
        background-color: #08b577;
        padding: 5px;
        border-radius: 2px;
    }
    .success p {
        margin: 0px;
    }
</style>