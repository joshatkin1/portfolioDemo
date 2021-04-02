import {combineReducers} from 'redux';
import profileReducers from './profileReducers.js';
import userReducers from './userReducers.js';

export default combineReducers({
    profile: profileReducers,
    user: userReducers,
});
