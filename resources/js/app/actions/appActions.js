import {
    NAVIGATE_APP,
    NAVIGATE_CLOUD,
    TOGGLE_APP_NAV_VIEWABLE,
    OPEN_APP_NOTIF,
    CLOSE_APP_NOTIF,
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
