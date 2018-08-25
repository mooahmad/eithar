<template>
    <div>
        <div class="form-group">
            <label class="control-label">{{ 'admin.type' | trans }} </label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="0" type="radio" checked/>
                    {{ 'admin.single_answer' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="1" type="radio"/>
                    {{ 'admin.multiple_answer' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="2" type="radio"/>
                    {{ 'admin.text' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="3" type="radio"/>
                    {{ 'admin.long_text' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="4" type="radio"/>
                    {{ 'admin.date_time' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input @click="swapTypeView" name="type" value="5" type="radio"/>
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
                let currentView = "Single";
                switch ($(event.target).val()) {
                    case "0":
                        currentView = "Single";
                        break;
                    case "1":
                        currentView = "Multiple";
                        break;
                    case "2":
                        currentView = "TextData";
                        break;
                    case "3":
                        currentView = "LongText";
                        break;
                    case "4":
                        currentView = "DateTime";
                        break;
                    case "5":
                        currentView = "Rating";
                        break;
                }
                this.$set(this.data, "currentView", currentView);
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