<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Font Awesome CSS -->
    <link href="{{ asset('vendor/fontawesome-free-5.14.0-web/css/all.min.css') }}" rel="stylesheet"/>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>

    <title>UpUdate Weather Case-Study</title>
    <style>
        .weather-sun {
            background-color: #ffcc80;
        }

        .weather-clouds {
            background-color: #e0e0e0;
        }

        .weather-snow {
            background-color: #f0f0f0;
        }

        .weather-rain {
            background-color: #9fa8da;
        }

        .weather-thunderstorm {
            background-color: #3f51b5;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex">
        <h4>UpUdate Weather Case-Study</h4>
        <div class="ml-auto">
            <select id="cities">
                <!-- loading -->
            </select>
        </div>
    </div>

    <div id="load-container" class="col-md-12 mt-5">
        <p class="text-center">Please choose city!</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        const cities = $('#cities'),
            container = $('#load-container'),
            weatherArray = {
                'Clear': {
                    'class': 'weather-sun',
                    'icon': 'fa-sun',
                },
                'Clouds': {
                    'class': 'weather-clouds',
                    'icon': 'fa-cloud',
                },
                'Snow': {
                    'class': 'weather-snow',
                    'icon': 'fa-snowflake',
                },
                'Rain': {
                    'class': 'weather-rain',
                    'icon': 'fa-tint',
                },
                'Thunderstorm': {
                    'class': 'weather-thunderstorm',
                    'icon': 'fa-poo-storm',
                }
            };

        cities.on('change', function () {
            let cityId = $(this).val();
            $.ajax({
                type: 'POST',
                url: '/weather/' + cityId,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function () {
                    container.html('<p class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x"></i></p>');
                },
                success: function (data) {
                    let date = new Date(),
                        hour = date.getUTCHours() + (data.timezone / 3600),
                        second = date.getUTCMinutes(),
                        weather = weatherArray[data.weather[0].main];

                    if (data.id === undefined) {
                        container.html('<p class="text-center">Please choose city!</p>');
                    } else {
                        container.html('' +
                            '<div class="card ' + weather.class + '">\n' +
                            '   <div class="card-body pb-0">\n' +
                            '       <i class="fa ' + weather.icon + ' fa-3x pb-4"></i>\n' +
                            '       <div class="d-flex justify-content-between">\n' +
                            '           <p class="mb-0 h5">' + Math.round(data.main.temp) + '&deg;</p>\n' +
                            '           <p class="mb-0 hour">' + hour + ':' + second + '</p>\n' +
                            '       </div>\n' +
                            '   </div>\n' +
                            '   <hr>\n' +
                            '   <div class="card-body pt-0">\n' +
                            '       <h6 class="font-weight-bold mb-1">' + data.name + '</h6>\n' +
                            '       <p class="mb-0">' + data.weather[0].main + ' - ' + data.weather[0].description + '</p>\n' +
                            '   </div>\n' +
                            '</div>' +
                            '');
                    }
                },
                error: function (xhr) {
                    container.html('<p class="text-center">' + xhr.responseText + '</p>');
                }
            });
        });

        cities.select2({
            width: '100%',
            placeholder: "Select a city",
            allowClear: true,
            ajax: {
                url: '/city.list.json',
                dataType: "json",
                cache: true,
                results: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    });
</script>

</body>
</html>
