<template>
    <div>
        <div class="form-group">
            <label class="control-label">{{ 'admin.type' | trans }} </label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="Single" type="radio" checked/>
                    {{ 'admin.single_answer' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="Multiple" type="radio"/>
                    {{ 'admin.multiple_answer' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="TextData" type="radio"/>
                    {{ 'admin.text' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="LongText" type="radio"/>
                    {{ 'admin.long_text' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="DateTime" type="radio"/>
                    {{ 'admin.date_time' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="Rating" type="radio"/>
                    {{ 'admin.rating' | trans }}
                    <span></span>
                </label>
            </div>
        </div>
        <component :is="data.currentView"></component>
    </div>
</template>

<script>
    import Single from './single';
    import Multiple from './multiple';
    import TextData from './text';
    import LongText from './longText';
    import DateTime from './dateTime';
    import Rating from './rating';

    export default {
        data: function () {
            return {
                data: {
                    currentView: "Single"
                }
            }
        },
        methods: {
            swapTypeView: function (event) {
                this.$set(this.data, "currentView", $(event.target).val());
            }
        },
        components: {
            Single: Single,
            Multiple: Multiple,
            TextData: TextData,
            LongText: LongText,
            DateTime: DateTime,
            Rating: Rating
        }
    }
</script>