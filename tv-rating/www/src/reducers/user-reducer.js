import { user as constants } from 'constants';

export default (state = {
    registration: {},
    profile: {},
    invitation: {},
    authentication: {},
    debunking: {},
    recovery: {},
    password: {}
}, action) => {
    switch (action.type) {
        case constants.REGISTRATION:
            return { ...state, registration: {} };
        case constants.REGISTRATION_PENDING:
            return {
                ...state,
                registration: {
                    meta: {
                        status: 102
                    }
                }
            };
        case constants.REGISTRATION_FULFILLED:
            return { ...state, registration: action.payload };
        case constants.REGISTRATION_REJECTED:
            return { ...state, registration: action.payload };

        case constants.PROFILE:
            return { ...state, profile: {} };
        case constants.PROFILE_PENDING:
            return {
                ...state,
                registration: {
                    meta: {
                        status: 102
                    }
                }
            };
        case constants.PROFILE_FULFILLED:
            return { ...state, registration: action.payload };
        case constants.PROFILE_REJECTED:
            return { ...state, registration: action.payload };

        case constants.INVITATION:
            return { ...state, invitation: {} };
        case constants.INVITATION_PENDING:
            return {
                ...state,
                invitation: {
                    meta: {
                        status: 102
                    }
                }
            };
        case constants.INVITATION_FULFILLED:
            return { ...state, invitation: action.payload };
        case constants.INVITATION_REJECTED:
            return { ...state, invitation: action.payload };

        case constants.AUTHENTICATION:
            return { ...state, authentication: {} };
        case constants.AUTHENTICATION_PENDING:
            return {
                ...state,
                authentication: {
                    meta: {
                        status: 102
                    }
                }
            };
        case constants.AUTHENTICATION_FULFILLED:
            return { ...state, authentication: action.payload };
        case constants.AUTHENTICATION_REJECTED:
            return { ...state, authentication: action.payload };

        case constants.DEBUNKING:
            return { ...state, debunking: {} };
        case constants.DEBUNKING_PENDING:
            return {
                ...state,
                debunking: {
                    meta: {
                        status: 102
                    }
                }
            };
        case constants.DEBUNKING_FULFILLED:
            return { ...state, debunking: action.payload };
        case constants.DEBUNKING_REJECTED:
            return { ...state, debunking: action.payload };

        case constants.RECOVERY:
            return { ...state, recovery: {} };
        case constants.RECOVERY_PENDING:
            return {
                ...state,
                recovery: {
                    meta: {
                        status: 102
                    }
                }
            };
        case constants.RECOVERY_FULFILLED:
            return { ...state, recovery: action.payload };
        case constants.RECOVERY_REJECTED:
            return { ...state, recovery: action.payload };

        case constants.PASSWORD:
            return { ...state, password: {} };
        case constants.PASSWORD_PENDING:
            return {
                ...state,
                password: {
                    meta: {
                        status: 102
                    }
                }
            };
        case constants.PASSWORD_FULFILLED:
            return { ...state, password: action.payload };
        case constants.PASSWORD_REJECTED:
            return { ...state, password: action.payload };

        default:
            return { ...state };
    }
};