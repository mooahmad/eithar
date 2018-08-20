<template>
    <div class="form-group">
        <input name="ar_text_option[]" type="text" class="form-control" required="required" :placeholder="'Enter arabic option ' + count" >
        <br>
        <input name="en_text_option[]" type="text" class="form-control" required="required" :placeholder="'Enter english option ' + count" >
        <br>
    </div>
</template>

<script>
    export default {
        props: ["count"],

    }
</script>