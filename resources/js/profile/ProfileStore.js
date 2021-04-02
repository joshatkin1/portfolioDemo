import {createStore, applyMiddleware} from 'redux';
import thunk from 'redux-thunk';
import rootReducer from './reducers';
import reduxMulti from 'redux-multi';

const initialState = {};

const middleware = [thunk, reduxMulti];

const profileStore = createStore(rootReducer, initialState, applyMiddleware(...middleware));


console.log('initial state:' , profileStore.getState());
profileStore.subscribe(() => console.log('Updated State:' , profileStore.getState()));

export default profileStore;
