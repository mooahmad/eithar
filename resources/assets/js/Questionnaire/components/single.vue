<template>
    <div>
        <TextOption v-for="(option, index) in data.options" v-bind:key="index" :count="index" :option_ar="option.option_ar" :option_en="option.option_en"></TextOption>
        <div class="form-group">
            <a href="javascript:void(0)" @click="increamtOptions" class="btn green">Add more</a>
        </div>
    </div>
</template>

<script>
    import textOption from './textInput';
    export default {
        props: ["questionnaire"],
        data: function () {
            return {
                data: {
                    options: [],
                    maxOptionsCount: 5
                }
            }
        },
        mounted: function () {
            let thisVue = this;
            if(thisVue.questionnaire !== null)
          $.each(thisVue.questionnaire.options_ar, function (key, value) {
              thisVue.data.options.push({option_ar: thisVue.questionnaire.options_ar[key], option_en: thisVue.questionnaire.options_en[key]});
          });
        },
        methods: {
            increamtOptions: function (event) {
                if (this.data.options.length !== this.data.maxOptionsCount)
                    this.data.options.push({option_ar: "", option_en: ""});
            }
        },
        components: {
            TextOption: textOption,
        }
    }
</script>