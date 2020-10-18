import {
    NAVIGATE_APP,
} from '../actions/actionTypes.js';

const initialState = {
    appPage:"dashboard",
}

export default function(state = initialState, action){
    switch(action.type){
        case 'NAVIGATE_APP':
            return {
                ...state,
                appPage : action.payload
            };
            break;
        default:
            return state;
    }
}
