import {
    FETCH_SESSION_DATA,
    FETCH_USER_COMPANY_NAME,
} from '../actions/actionTypes.js';

const initialState = {
    sessionData:{},
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
        default:
            return state;
    }
}
