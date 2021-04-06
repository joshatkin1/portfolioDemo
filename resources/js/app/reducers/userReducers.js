import {
    FETCH_SESSION_DATA,
    FETCH_USER_COMPANY_NAME,
    FETCH_USERS_CLOUD_INVITATIONS,
} from '../actions/actionTypes.js';

const initialState = {
    sessionData:{},
    cloudInvitations:[],
}

export default function(state = initialState, action){
    switch(action.type){
        case 'FETCH_SESSION_DATA':
            return {
                ...state,
                sessionData : action.payload
            };
            break;
        case 'FETCH_USER_COMPANY_NAME':
            return {
                ...state,
                sessionData : {
                    ...state.sessionData,
                    company_name : action.payload,
                }
            };
            break;
        case 'FETCH_USERS_CLOUD_INVITATIONS':
            return {
                ...state,
                cloudInvitations:action.payload
            };
            break;
        default:
            return state;
    }
}
