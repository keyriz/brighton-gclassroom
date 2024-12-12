(function ($) {
    $(document).ready(function () {
        const provinceField = $('#Form_ItemEditForm_Province');
        const cityField = $('#Form_ItemEditForm_City');
        const districtField = $('#Form_ItemEditForm_District');

        // Fetch provinces
        $.get('https://wilayah.id/api/provinces.json', function (response) {
            provinceField.empty().append('<option value="">Select a province</option>');
            $.each(response.data, function (index, province) {
                provinceField.append(
                    $('<option></option>').val(province.code).text(province.name)
                );
            });
        });

        // Fetch cities based on province
        provinceField.change(function () {
            const provinceId = $(this).val();
            cityField.empty().append('<option value="">Select a city</option>');
            districtField.empty().append('<option value="">Select a district</option>');

            if (provinceId) {
                $.get(`https://wilayah.id/api/regencies/${provinceId}.json`, function (response) {
                    $.each(response.data, function (index, city) {
                        cityField.append(
                            $('<option></option>').val(city.code).text(city.name)
                        );
                    });
                });
            }
        });

        // Fetch districts based on city
        cityField.change(function () {
            const cityId = $(this).val();
            districtField.empty().append('<option value="">Select a district</option>');

            if (cityId) {
                $.get(`https://wilayah.id/api/districts/${cityId}.json`, function (response) {
                    $.each(response.data, function (index, district) {
                        districtField.append(
                            $('<option></option>').val(district.code).text(district.name)
                        );
                    });
                });
            }
        });
    });
})(jQuery);
