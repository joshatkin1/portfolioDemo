import {
    NAVIGATE_PROFILE,
    TOGGLE_APP_NAV_VIEWABLE,
    OPEN_APP_NOTIF,
    CLOSE_APP_NOTIF,
} from './actionTypes.js';

export const navigateProfilePage = (newPage) => dispatch => {
    dispatch({
        type: NAVIGATE_PROFILE,
        payload:newPage,
    });
}
export const toggleAppNavViewable = () => dispatch => {
    dispatch({
        type: TOGGLE_APP_NAV_VIEWABLE,
    })
}
export const openAppNotif = (notif) => dispatch => {
    dispatch({
        type: OPEN_APP_NOTIF,
        payload: notif,
    })
}
export const closeAppNotif = () => dispatch => {
    dispatch({
        type: OPEN_APP_NOTIF,
    })
}
