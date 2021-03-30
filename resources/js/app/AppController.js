import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from './actions/appActions.js';
import {fetchSessionData} from './actions/userActions.js';

//MAJOR CONTROLLER COMPONENTS
import HeaderComponent from './components/HeaderComponent.js';
import SideNav from "./components/SideNav";
import AccountPage from "./pages/AccountPage";
import NotificationsPage from "./pages/NotificationsPage";
import MessagesPage from "./pages/MessagesPage";
import CloudPage from "./pages/CloudPage";
import {CURRENT_CLIENT_DETAILS, TOGGLE_CLIENT_PAGE_SECTION} from "./actions/actionTypes";

class AppController extends Component{
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
        console.log('AppController componentDidMount');
        this.props.fetchSessionData();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {appPage, cloudPage} = this.props;

        if(appPage !== nextProps.appPage
        || cloudPage !== nextProps.cloudPage){
            return true;
        }

        return false;
    }

    displayAppPage(){
        var {appPage} = this.props;

        switch(appPage){
            case 'account' : return (<AccountPage key={v4()} />) ;break;
            case 'notifications' : return (<NotificationsPage key={v4()} />) ;break;
            case 'messaging' : return (<MessagesPage key={v4()} />) ;break;
            case 'cloud' : return (<CloudPage key={v4()} />) ;break;
        }
    }

    render(){
        return (
                <div className={"content-wrap algn-cntr"}>
                    <div className={"header-bar content-wrap algn-cntr"}>
                            <HeaderComponent key={v4()}/>
                    </div>
                    <div className={"body-content-wrap algn-cntr"}>
                        <div className={"content-wrap"} style={{justifyContent:"stretch"}}>
                            <div className={"container"}>
                                {this.displayAppPage()}
                            </div>
                        </div>
                    </div>
                </div>
        );
    }
}

AppController.propTypes = {
    navigateAppPage: PropTypes.func.isRequired,
    fetchSessionData: PropTypes.func.isRequired,
    sessionData: PropTypes.object.isRequired,
    appPage: PropTypes.string.isRequired,
    cloudPage: PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
    appPage: state.app.appPage,
    cloudPage: state.app.cloudPage,
});

export default connect(mapStateToProps , {navigateAppPage, fetchSessionData})(AppController);
