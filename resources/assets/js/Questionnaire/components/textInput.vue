<template>
    <div class="form-group">
        <input name="options_ar[]" type="text" class="form-control" required="required" :placeholder="'Enter arabic option ' + count" >
        <br>
        <input name="options_en[]" type="text" class="form-control" required="required" :placeholder="'Enter english option ' + count" >
        <br>
    </div>
</template>

<script>
    export default {
        props: ["count"],

    }
</script>