<template>
    <div>
        <div class="form-group">
            <label class="control-label">{{ 'admin.type' | trans }} </label>
            <div class="mt-radio-inline">
                <label class="mt-radio">
                    <input id="Single" @click="clickSwapper" name="type" value="0" type="radio" checked/>
                    {{ 'admin.single_answer' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input id="Multiple" @click="clickSwapper" name="type" value="1" type="radio"/>
                    {{ 'admin.multiple_answer' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input id="TextData" @click="clickSwapper" name="type" value="2" type="radio"/>
                    {{ 'admin.text' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input id="LongText" @click="clickSwapper" name="type" value="3" type="radio"/>
                    {{ 'admin.long_text' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input id="DateTime" @click="clickSwapper" name="type" value="4" type="radio"/>
                    {{ 'admin.date_time' | trans }}
                    <span></span>
                </label>
                <label class="mt-radio">
                    <input id="Rating" @click="clickSwapper" name="type" value="5" type="radio"/>
                    {{ 'admin.rating' | trans }}
                    <span></span>
                </label>
            </div>
        </div>
        <component v-if="data.questionnaire !== null || data.isCreate" :is="data.currentView" :questionnaire="data.questionnaire"></component>
    </div>
</template>

<script>
    import Single from './single';
    import Multiple from './multiple';
    import TextData from './text';
    import LongText from './longText';
    import DateTime from './dateTime';
    import Rating from './rating';
    import axios from 'axios';

    export default {
        data: function () {
            return {
                data: {
                    currentView: "Single",
                    questionnaire: null,
                    isCreate: false
                }
            }
        },
        methods: {
            clickSwapper: function (event){
                this.swapTypeView($(event.target).val(), true);
        },
            swapTypeView: function (type, isClicked = true) {
                let currentView = "Single";
                type = parseInt(type);
                switch (type) {
                    case 0:
                        currentView = "Single";
                        break;
                    case 1:
                        currentView = "Multiple";
                        break;
                    case 2:
                        currentView = "TextData";
                        break;
                    case 3:
                        currentView = "LongText";
                        break;
                    case 4:
                        currentView = "DateTime";
                        break;
                    case 5:
                        currentView = "Rating";
                        break;
                }
                if(!isClicked) {
                    $('#' + currentView).click();
                    return;
                }
                this.$set(this.data, "currentView", currentView);
            }
        },
        mounted: function () {
            let thisVue = this;
            let questionnaireId = $('input[name="id"]').val();
            if (questionnaireId != '') {
                axios.post(baseUrl + '/Administrator/services/questionnaire/options', {
                    id: questionnaireId
                })
                    .then(function (response) {
                        thisVue.data.questionnaire = response.data;
                        thisVue.swapTypeView(thisVue.data.questionnaire.type, false);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }else{
                thisVue.data.isCreate = true;
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