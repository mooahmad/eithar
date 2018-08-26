<template>
    <div>
    <div class="form-group">
        <label class="control-label">
            {{ 'admin.symbol' | trans }} <span class="required"> * </span>
        </label>
        <select name="symbol" id="symbol" class="form-control">
            <option value="0" selected>Stars</option>
            <option value="1">Numeric</option>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">
            {{ 'admin.rating_levels' | trans }} <span class="required"> * </span>
        </label>
        <select name="rating_levels" id="rating_levels" class="form-control">

        </select>
    </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        methods:{

        },
        mounted: function () {
            $('#symbol').find('option[value="'+questionnaireCurrentSymbol+'"]').prop('selected', true);
            $('#symbol').on('change', function () {
                axios.get(baseUrl + '/Administrator/services/questionnaire/symbollevels/' + $(this).find('option:selected').val())
                    .then(function (response) {
                        $('#rating_levels').find('option').remove().end();
                        for (var i =1; i <= response.data.levels; i++) {
                            let option = '<option value="'+i+'">'+i+'</option>';
                            if(i === parseInt(questionnaireCurrentLevels))
                                option = '<option value="'+i+'" selected>'+i+'</option>';
                            $('#rating_levels').append(option);
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }).change();
        }
    }
</script>