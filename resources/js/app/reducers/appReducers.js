import {
    NAVIGATE_APP,
    NAVIGATE_CLOUD,
} from '../actions/actionTypes.js';

const initialState = {
    appPage:"account",
    cloudPage:"Dashboard",
}

export default function(state = initialState, action){
    switch(action.type){
        case 'NAVIGATE_APP':
            return {
                ...state,
                appPage : action.payload
            };
            break;
        case 'NAVIGATE_CLOUD':
            return {
                ...state,
                cloudPage : action.payload
            };
            break;
        default:
            return state;
    }
}
