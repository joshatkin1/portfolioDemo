import {
    FETCH_COMPANY_CLOUD_DETAILS,
} from './actionTypes.js';

export const submitCompanyCloudRegistration = (data) => dispatch => {
    axios({ method: 'POST', url: 'api/app/cloud/registration/submit', validateStatus: () => true , data : data})
        .then( response => {

                if(response.status === 200){
                    dispatch({
                        type: FETCH_COMPANY_CLOUD_DETAILS,
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
