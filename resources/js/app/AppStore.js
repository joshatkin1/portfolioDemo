import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import rootReducer from './reducers';
import reduxMulti from 'redux-multi';

const initialState = {};

const middleware = [thunk, reduxMulti];

const appStore = createStore(rootReducer, initialState, applyMiddleware(...middleware));


console.log('initial state:' , appStore.getState());
appStore.subscribe(() => console.log('Updated State:' , appStore.getState()));


export default appStore;
