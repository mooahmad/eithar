<template>
    <div>
        <TextOption v-for="count in data.optionsCount" v-bind:key="count.num" :count="count.num"></TextOption>
        <div class="form-group">
            <a href="javascript:void(0)" @click="increamtOptions" class="btn green">Add more</a>
        </div>
    </div>
</template>

<script>
    import textOption from './textInput';
    export default {
        data: function () {
            return {
                data: {
                    optionsCount:[{
                        num : 1
                    }],
                    maxOptionsCount: 5
                }
            }
        },
        methods: {
            increamtOptions: function (event) {
                if(this.data.optionsCount.length !== this.data.maxOptionsCount)
                    this.data.optionsCount.push({num: this.data.optionsCount.length + 1});
            }
        },
        components: {
            TextOption: textOption,
        }
    }
</script>