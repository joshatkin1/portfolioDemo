import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter,
    Switch,
    Route,
} from "react-router-dom";
import  {Provider} from 'react-redux';
import profileStore from './ProfileStore.js';
import { v4 } from 'uuid';
import ProfileController from "./ProfileController.js";

//IMPORT PAGES BELOW

export default function SiteRouting() {
    return (
        <BrowserRouter>
            <Switch>
                <Route exact path="/profile">
                    <Provider store={profileStore}><ProfileController key={v4()}/></Provider>
                </Route>
            </Switch>
        </BrowserRouter>
    );
}

ReactDOM.render(
    <SiteRouting />,
    document.getElementById('root')
);
