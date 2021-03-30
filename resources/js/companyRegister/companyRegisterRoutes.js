import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter,
    Switch,
    Route,
} from "react-router-dom";
import  {Provider} from 'react-redux';
import { v4 } from 'uuid';
import companyRegisterStore from './companyRegisterStore.js';
import CompanyRegisterComponent from './CompanyRegisterComponent.js';

//IMPORT PAGES BELOW

export default function SiteRouting() {
    return (
        <BrowserRouter>
            <Switch>
                <Route exact path="/company/register">
                    <Provider store={companyRegisterStore}><CompanyRegisterComponent key={v4()}/></Provider>
                </Route>
            </Switch>
        </BrowserRouter>
    );
}

ReactDOM.render(
    <SiteRouting />,
    document.getElementById('root')
);
