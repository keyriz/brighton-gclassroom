(function ($) {
    $(document).ready(function () {
        const provinceField = $('#Form_ItemEditForm_Province');
        const cityField = $('#Form_ItemEditForm_City');
        const districtField = $('#Form_ItemEditForm_District');

        // Fetch provinces
        // $.get('http://api.caller/province', function (response) {
        //     provinceField.chosen('destroy').chosen();
        //     provinceField.empty().append('<option value="">-- Select a Province --</option>');
        //     $.each(response.data, function (index, province) {
        //         provinceField.append(
        //             $('<option></option>').val(province.code + ';' + province.name).text(province.name)
        //         );
        //     });
        //     provinceField.trigger("liszt:updated");
        // });

        // Fetch cities based on province
        provinceField.change(function () {
            const provinceVal = $(this).val().split(';');
            cityField.empty().append('<option value="">-- Select a City --</option>');
            districtField.empty().append('<option value="">-- Select a District --</option>');

            if (provinceVal[0]) {
                console.log('masuk');
                $.get(`http://api.caller/city?id=${provinceVal[0]}`, function (response) {
                    $.each(response.data, function (index, city) {
                        cityField.append(
                            $('<option></option>').val(province.code + ';' + province.name).text(city.name)
                        );
                    });
                });
            }

            cityField.trigger("liszt:updated");
        });

        // Fetch districts based on city
        cityField.change(function () {
            const cityVal = $(this).val().split(';');
            districtField.empty().append('<option value="">-- Select a District --</option>');

            if (cityVal[0]) {
                $.get(`http://api.caller/district?id=${cityVal[0]}`, function (response) {
                    $.each(response.data, function (index, district) {
                        districtField.append(
                            $('<option></option>').val(province.code + ';' + province.name).text(district.name)
                        );
                    });
                });
            }
            districtField.trigger("liszt:updated");
        });
    });
})(jQuery);
