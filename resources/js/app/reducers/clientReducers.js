import {
    TOGGLE_CLIENT_PAGE_SECTION,
    UPDATE_CLIENT_SEARCH_VALUE,
    CURRENT_CLIENT_DETAILS,
    SET_CLIENT_SEARCH_OPTIONS,
    SET_CURRENT_CLIENT_DETAILS,
    SET_CLIENT_SEARCH_PAGINATION_OPTIONS,
    ADD_RECENT_CLIENT_ACCOUNT,
} from '../actions/actionTypes.js';

const initialState = {
    clientPageSection: "clientSearch",
    clientSearchValue: "",
    clientAccountDetails:{},
    currentClientAccountNotes:[],
    recentClientAccounts:[],
    clientSearchOptions:[],
    clientSearchPaginationOptions:[],
    clientSearchPaginationPage: 1,
    clientSearchPaginationLastPage:1,
    clientSearchPaginationTotal:0,
}

export default function(state = initialState, action){
    switch(action.type){
        case 'TOGGLE_CLIENT_PAGE_SECTION':
            return {
                ...state,
                clientPageSection: action.payload
            };
            break;
        case 'UPDATE_CLIENT_SEARCH_VALUE':
            return {
                ...state,
                clientSearchValue: action.payload
            };
            break;
        case 'CURRENT_CLIENT_DETAILS':
            return {
                ...state,
                clientAccountDetails: action.payload
            };
            break;
        case 'SET_CLIENT_SEARCH_OPTIONS':
            return {
                ...state,
                clientSearchOptions: action.payload
            }
            break;
        case 'SET_CURRENT_CLIENT_DETAILS':
            return {
                ...state,
                clientAccountDetails: action.payload
            }
            break;
        case 'SET_CLIENT_SEARCH_PAGINATION_OPTIONS':
            return {
                ...state,
                clientSearchOptions:[],
                clientSearchPaginationOptions: action.payload.data,
                clientSearchPaginationPage: action.payload.current_page,
                clientSearchPaginationLastPage: action.payload.last_page,
                clientSearchPaginationTotal: action.payload.total,
            }
            break;
        case 'ADD_RECENT_CLIENT_ACCOUNT':
            var accCheck = state.recentClientAccounts.filter((cli) => cli.id === action.payload.id);
            if(accCheck.length === 0){
                return {
                    ...state,
                    recentClientAccounts : state.recentClientAccounts.concat(action.payload)
                }
            }else{
                return {
                    ...state,
                }
            }
            break;
        default:
            return state;
    }
}
