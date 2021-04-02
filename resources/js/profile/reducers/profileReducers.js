import {
    NAVIGATE_PROFILE,
    TOGGLE_APP_NAV_VIEWABLE,
    OPEN_APP_NOTIF,
    CLOSE_APP_NOTIF,
} from '../actions/actionTypes.js';

const initialState = {
    profilePage: "profile",
    appNavBarViewable:false,
    appNotif:"",
}

export default function(state = initialState, action){
    switch(action.type){
        case 'NAVIGATE_PROFILE':
            return {
                ...state,
                profilePage : action.payload
            };
            break;
        case 'TOGGLE_APP_NAV_VIEWABLE':
            return {
                ...state,
                appNavBarViewable : !state.appNavBarViewable
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
        default:
            return state;
    }
}
