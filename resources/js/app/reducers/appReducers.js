import {
    NAVIGATE_APP,
    NAVIGATE_CLOUD,
    TOGGLE_APP_NAV_VIEWABLE,
    OPEN_APP_NOTIF,
    CLOSE_APP_NOTIF,
} from '../actions/actionTypes.js';

const initialState = {
    appPage:"home",
    cloudPage:"Dashboard",
    appNotif: "",
    appNavBarViewable:false,
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
        case 'OPEN_APP_NOTIF':
            return {
                ...state,
                appNotif : action.payload
            };
            break;
        case 'CLOSE_APP_NOTIF':
            return {
                ...state,
                appNotif : ""
            };
            break;
        case 'TOGGLE_APP_NAV_VIEWABLE':
            return {
                ...state,
                appNavBarViewable : !state.appNavBarViewable
            };
            break;
        default:
            return state;
    }
}
