import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import rootReducer from './reducers';
import reduxMulti from 'redux-multi';

const initialState = {};

const middleware = [thunk, reduxMulti];

const companyRegisterStore = createStore(rootReducer, initialState, applyMiddleware(...middleware));


console.log('initial state:' , companyRegisterStore.getState());
companyRegisterStore.subscribe(() => console.log('Updated State:' , companyRegisterStore.getState()));


export default companyRegisterStore;
