import {
    NAVIGATE_ACCOUNT,
    NAVIGATE_ACCOUNT_PAGE_SECTION,
} from '../actions/actionTypes.js';

const initialState = {
    accountPage: "profile",
    accountPageSection: "about",
}

export default function(state = initialState, action){
    switch(action.type){
        case 'NAVIGATE_ACCOUNT':
            var pagSec = "about";
            switch(action.payload){
                case "profile": pagSec = "about";break;
                case "work": pagSec = "preferences";break;
            }
            return {
                ...state,
                accountPage : action.payload,
                accountPageSection: pagSec,
            };
            break;
        case 'NAVIGATE_ACCOUNT_PAGE_SECTION':
            return {
                ...state,
                accountPageSection : action.payload
            };
            break;
        default:
            return state;
    }
}
