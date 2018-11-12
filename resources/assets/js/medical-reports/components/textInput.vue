<template>
    <div class="form-group">
        <input name="options_ar[]" type="text" :value="option_ar" class="form-control" required="required" :placeholder="'Enter arabic option ' + count" >
        <br>
        <input name="options_en[]" type="text" :value="option_en" class="form-control" required="required" :placeholder="'Enter english option ' + count" >
        <br>
    </div>
</template>

<script>
    export default {
        props: ["count", "option_ar", "option_en"],

    }
</script>