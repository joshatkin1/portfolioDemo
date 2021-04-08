import {combineReducers} from 'redux';
import appReducers from './appReducers.js';
import userReducers from './userReducers.js';
import clientReducers from './clientReducers.js';
import accountReducers from "./accountReducers";
import cloudReducers from "./cloudReducers";

export default combineReducers({
    app: appReducers,
    user: userReducers,
    client: clientReducers,
    account: accountReducers,
    cloud: cloudReducers,
});
