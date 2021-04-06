import {
    TOGGLE_CLIENT_PAGE_SECTION,
    CURRENT_CLIENT_DETAILS,
    SET_CLIENT_SEARCH_OPTIONS,
    SET_CURRENT_CLIENT_DETAILS,
    SET_CLIENT_SEARCH_PAGINATION_OPTIONS,
    ADD_RECENT_CLIENT_ACCOUNT,
} from './actionTypes.js';

export const toggleClientContentPage = (page) => dispatch => {
    dispatch({
        type: TOGGLE_CLIENT_PAGE_SECTION,
        payload:page
    });
}

export const submitCreateClientForm = (data) => dispatch => {

    axios.post('api/resources/clients/create/',data)
        .then(response => {
            dispatch({
                type: CURRENT_CLIENT_DETAILS,
                payload: response.data
            })
        }).then(
        dispatch({
            type: TOGGLE_CLIENT_PAGE_SECTION,
            payload: "clientAccount",
        })
    )
        .catch( errors => {
            console.log(errors);
        })
}

export const updateClientSearchOptions = (search) => dispatch => {

    axios.get('api/resources/clients/search?search_value=' + search)
        .then(response => {
            dispatch({
                type: SET_CLIENT_SEARCH_OPTIONS,
                payload: response.data
            })
        })
        .catch( errors => {
            console.log(errors);
        })
}

export const setCurrentClientAccountDetails = (currentClient) => dispatch => {
    dispatch({
        type: SET_CURRENT_CLIENT_DETAILS,
        payload: currentClient
    })
    dispatch({
        type: ADD_RECENT_CLIENT_ACCOUNT,
        payload: currentClient
    })
}

export const paginateClientSearchAll = (search, clientSearchPage) => dispatch => {

    axios.get('api/resources/clients/search/all/paginate?search_value=' + search + '&page=' + clientSearchPage)
        .then(response => {
            dispatch({
                type: SET_CLIENT_SEARCH_PAGINATION_OPTIONS,
                payload: response.data
            })
        })
        .catch( errors => {
            console.log(errors);
        })
}
