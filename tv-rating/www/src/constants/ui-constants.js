export default {
    SIZE_SMALL:  'small',
    SIZE_MEDIUM: 'medium',
    SIZE_NORMAL: 'normal',
    SIZE_BIG:    'big',
    get SIZES() {
        return [this.SIZE_SMALL, this.SIZE_MEDIUM, this.SIZE_NORMAL, this.SIZE_BIG];
    },

    COLOR_BLUE:  'blue',
    COLOR_GREEN: 'green',
    COLOR_RED:   'red',
    COLOR_WHITE: 'white',
    get COLORS() {
        return [this.COLOR_BLUE, this.COLOR_GREEN, this.COLOR_RED, this.COLOR_WHITE];
    },

    BUTTON_TYPE_BUTTON: 'button',
    BUTTON_TYPE_SUBMIT: 'submit',
    BUTTON_TYPE_RESET:  'reset',
    get BUTTON_TYPES() {
        return [this.BUTTON_TYPE_BUTTON, this.BUTTON_TYPE_SUBMIT, this.BUTTON_TYPE_RESET];
    },

    STATUS_SUCCESS: 'success',
    STATUS_WARNING: 'warning',
    STATUS_DANGER:  'danger',
    STATUS_INFO:    'info',
    get STATUSES() {
        return [this.STATUS_SUCCESS, this.STATUS_WARNING, this.STATUS_DANGER, this.STATUS_INFO];
    }
};