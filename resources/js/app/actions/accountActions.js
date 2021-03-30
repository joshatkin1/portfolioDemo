import {
    NAVIGATE_ACCOUNT,
    NAVIGATE_ACCOUNT_PAGE_SECTION,
} from './actionTypes.js';

export const navigateAccountPage = (newPage) => dispatch => {
    dispatch({
        type: NAVIGATE_ACCOUNT,
        payload:newPage,
    });
}
export const navigateAccountPageSection = (sec) => dispatch => {
    dispatch({
        type: NAVIGATE_ACCOUNT_PAGE_SECTION,
        payload:sec,
    });
}
