import {
    FETCH_SESSION_DATA,
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
        default:
            return state;
    }
}
