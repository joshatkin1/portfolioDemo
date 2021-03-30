import {
    NAVIGATE_APP,
    NAVIGATE_CLOUD,
} from './actionTypes.js';

export const navigateAppPage = (newPage) => dispatch => {
    dispatch({
        type: NAVIGATE_APP,
        payload:newPage,
    });
}
export const navigateCloudPage = (newPage) => dispatch => {
    dispatch({
        type: NAVIGATE_CLOUD,
        payload:newPage,
    });
}
