import {
    FETCH_SESSION_DATA,
} from './actionTypes.js';

export const fetchSessionData = () => dispatch => {

    axios({ method: 'GET', url: '/resources/app/data/session/all', validateStatus: () => true })
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
