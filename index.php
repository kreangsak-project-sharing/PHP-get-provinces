<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Provences Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form class="row g-2 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">First name</label>
                <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">Last name</label>
                <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputvillageprovinces" class="form-label">Province:</label>
                <select id="inputvillageprovinces" name="inputvillageprovinces" class="form-select" data-amphure="inputvillageamphure" data-tambon="inputvillagetambon" data-zipcode="zipcode" required>
                    <option selected disabled value=''>--- เลือกจังหวัด ---</option>
                </select>
                <div class="invalid-feedback">
                    ระบุจังหวัด
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputvillageamphure" class="form-label">Amphure:</label>
                <select id="inputvillageamphure" name="inputvillageamphure" class="form-select" data-amphure="inputvillageamphure" data-tambon="inputvillagetambon" data-zipcode="zipcode" required>
                    <option selected disabled value=''>--- เลือกอำเภอ ---</option>
                </select>
                <div class="invalid-feedback">
                    ระบุอำเภอ
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputvillagetambon" class="form-label">Tambon:</label>
                <select id="inputvillagetambon" name="inputvillagetambon" class="form-select" data-tambon="inputvillagetambon" data-zipcode="zipcode" required>
                    <option selected disabled value=''>--- เลือกตำบล ---</option>
                </select>
                <div class="invalid-feedback">
                    ระบุตำบล
                </div>
            </div>

            <div class="col-md-6">
                <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                <select class="form-select" id="zipcode" name="zipcode" required>
                    <option selected disabled value=''>--- เลือกรหัสไปรษณีย์ ---</option>
                </select>
                <div class="invalid-feedback">
                    ระบุรหัสไปรษณีย์
                </div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                        Agree to terms and conditions
                    </label>
                    <div class="invalid-feedback">
                        You must agree before submitting.
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>
    </div>
    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })

        })()
    </script>

    <script>
        // 
        // Function
        // Get Provinces
        const urlProvinces = "get_provinces.php";

        // Elements
        const provincesSelectors = [
            "#inputvillageprovinces",
        ];
        const amphuresSelectors = [
            "#inputvillageamphure",
        ];

        const tambonSelectors = [
            "#inputvillagetambon",
        ];

        // HTML backup
        const defaultAmphureHTML = $("#inputvillageamphure").html();
        const defaultTambonHTML = $("#inputvillagetambon").html();
        const defaultZipHTML = $("#zipcode").html();

        // Function to get data from server
        async function getData(type, id) {
            let data;
            try {
                data = await $.get(urlProvinces, {
                    type,
                    id,
                });
                return data;
            } catch (error) {
                console.error('An error occurred:', error);
                return null;
            }
        }

        // Function to handle provinces change
        async function onProvinceChange() {
            const value_id = this.value;
            const amp = $(this).data("amphure");
            const tam = $(this).data("tambon");
            const zip = $(this).data("zipcode");

            if (value_id === "") {
                $(`#${amp}`).html(defaultAmphureHTML);
                $(`#${tam}`).html(defaultTambonHTML);
                $(`#${zip}`).html(defaultZipHTML);
            } else {
                const data = await getData("AM", value_id);
                if (data) {
                    $(`#${amp}`).html(data);
                    $(`#${tam}`).html(defaultTambonHTML);
                    $(`#${zip}`).html(defaultZipHTML);
                }
            }
        }

        // Function to handle amphure change
        async function onAmphureChange() {
            const value_id = this.value;
            const tam = $(this).data("tambon");
            const zip = $(this).data("zipcode");

            if (value_id === "") {
                $(`#${tam}`).html(defaultTambonHTML);
                $(`#${zip}`).html(defaultZipHTML);
            } else {
                const data = await getData("TA", value_id);
                if (data) {
                    $(`#${tam}`).html(data);
                    $(`#${zip}`).html(defaultZipHTML);
                }
            }
        }

        // Function to handle tambon change
        async function onTambonChange() {
            const value_id = this.value;
            const zip = $(this).data("zipcode");
            console.log(value_id)

            if (value_id === "") {
                $(`#${zip}`).html(defaultZipHTML);
            } else {
                const data = await getData("ZC", value_id);
                if (data) {
                    $(`#${zip}`).html(data);
                }
            }
        }

        // Get initial province data
        (async function init() {
            const data = await getData("PR", "");
            if (data) {
                provincesSelectors.forEach((selector) => $(selector).html(data));
            }

            // Add change event listener to provinces selectors
            provincesSelectors.forEach((selector) =>
                $(document).on("change", selector, onProvinceChange)
            );

            // Add change event listener to amphures selectors
            amphuresSelectors.forEach((selector) =>
                $(document).on("change", selector, onAmphureChange)
            );

            // Add change event listener to tambon selectors
            tambonSelectors.forEach((selector) =>
                $(document).on("change", selector, onTambonChange)
            );
        })()
    </script>

</body>

</html>