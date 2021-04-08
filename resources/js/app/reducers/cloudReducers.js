import {
    FETCH_COMPANY_CLOUD_DETAILS,
} from '../actions/actionTypes.js';

const initialState = {
    companyDetails:{},
}

export default function(state = initialState, action){
    switch(action.type){
        case 'FETCH_COMPANY_CLOUD_DETAILS':
            return {
                ...state,
                companyDetails : action.payload
            };
            break;
        default:
            return state;
    }
}
