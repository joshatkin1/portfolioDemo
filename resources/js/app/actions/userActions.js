import {
    FETCH_SESSION_DATA,
    FETCH_USER_COMPANY_NAME,
    FETCH_USERS_CLOUD_INVITATIONS,
} from './actionTypes.js';

export const fetchSessionData = () => dispatch => {

    axios({ method: 'GET', url: 'api/resources/data/session/all', validateStatus: () => true })
        .then( response => {

                if(response.status === 200){
                    dispatch({
                        type: FETCH_SESSION_DATA,
                        payload: response.data
                    })

                }else{

                }

            }
        )
        .catch( errors => {
            console.log(errors);
        })
}

export const getCompanyLinkName = () => dispatch => {

    axios({ method: 'GET', url: 'api/resources/data/session/company-link-name', validateStatus: () => true })
        .then( response => {

                if(response.status === 200){
                    dispatch({
                        type: FETCH_USER_COMPANY_NAME,
                        payload: response.data
                    })

                }else{}

            }
        )
        .catch( errors => {
            console.log(errors);
        })
}

export const getUsersCompanyCloudInvitations = () => dispatch => {

    axios({ method: 'GET', url: 'api/resources/data/user/company/cloud/invitations', validateStatus: () => true })
        .then( response => {

                if(response.status === 200){
                    dispatch({
                        type: FETCH_USERS_CLOUD_INVITATIONS,
                        payload: response.data
                    })

                }else{}

            }
        )
        .catch( errors => {
            console.log(errors);
        })
}


