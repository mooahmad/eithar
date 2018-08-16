<template>
    <div>
        <div class="form-group">
            <label class="control-label">{{ 'admin.is_active' | trans }} </label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input  name="is_active" type="radio"/>
                    {{ 'admin.is_active' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input  name="is_active" type="radio"/>
                    {{ 'admin.is_active' | trans }}
                    <span></span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        components: {}
    }
</script>