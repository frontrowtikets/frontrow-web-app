import intlTelInput from 'intl-tel-input';
export default {
    data() {
        return {
            errorMap: ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"]
        }
    },
    methods: {
        initPhone(id) {

            let errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

            let input = document.querySelector("#"+id);
            let errorMsg = document.querySelector("#error-msg-"+id);

            let iti = intlTelInput(input, {
                utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.min.js"
            });

            let country = import.meta.env.VITE_COUNTRY_ISO_CODE || 'ss';
            iti.setCountry(country);

            let reset = function() {
                input.classList.remove("error");
                errorMsg.innerHTML = "";
                errorMsg.classList.add("error-hide");
            };

            // on blur: validate
            input.addEventListener('blur', function() {
                reset();
                if (input.value.trim()) {
                    if (!iti.isValidNumber()) {
                        input.classList.add("error");
                        let errorCode = iti.getValidationError();
                        errorMsg.innerHTML = errorMap[errorCode];
                        errorMsg.classList.remove("error-hide");
                    }
                }
            });

            // on keyup / change flag: reset
            input.addEventListener('change', reset);
            input.addEventListener('keyup', reset);
        }
    }
};

