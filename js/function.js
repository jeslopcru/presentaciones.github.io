(function () {
    $('#province-select').change(function () {
        $('#location-select').empty();
        $('#location-select').append($('<option>', {
            text: 'Selecciona una localidad'
        }));
        var value = this.value;
        $.getJSON("provinceList.json", function (data) {
            $.each(data[value].provinceList, function (index, value) {
                $('#location-select').append($('<option>', {
                    value: index,
                    text: value.name
                }));
            });
        }.bind(value));
    });

    $('#location-select').change(function () {
        $('#search-button').attr('href', '/guarderias-en-' + this.value + '/');
    });

    if ($('#province-select').length) {
        $.getJSON("provinceList.json", function (data) {
            $('#province-select').empty();
            $('#province-select').append($('<option>', {
                text: 'Selecciona una provincia'
            }));
            $.each(data, function (index, value) {
                $('#province-select').append($('<option>', {
                    value: index,
                    text: value.name
                }));
            });
        });
    }
})();