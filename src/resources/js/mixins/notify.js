import {POSITION, TYPE, useToast} from "vue-toastification";

const toast = useToast();
export const notify = {
    toastSuccessMessage:(message = "Request submitted successfully")=>
        toast(message,
            {
                type: TYPE.SUCCESS,
                position_text: POSITION.BOTTOM_LEFT,

            },
        ),
    toastErrorMessage:(message = "Something happened, try again!")=> toast(message,
            {
                type: TYPE.ERROR,
                position_text: POSITION.BOTTOM_LEFT
            },
        ),
    toastWarningMessage:(message = "Something happened, try again!")=> toast(message,
            {
                type: TYPE.WARNING,
                position_text: POSITION.BOTTOM_LEFT
            },
        ),
    toastInfoMessage:(message = "Something happened, try again!")=> toast(message,
            {
                type: TYPE.INFO,
                position_text: POSITION.BOTTOM_LEFT
            },
        ),

}

