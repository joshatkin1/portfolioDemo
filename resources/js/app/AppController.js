import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from './actions/appActions.js';
import {fetchSessionData} from './actions/userActions.js';

//MAJOR CONTROLLER COMPONENTS
import HeaderComponent from './components/header/HeaderComponent.js';
import NotificationsPage from "./pages/NotificationsPage.js";
import MessagesPage from "./pages/MessagesPage.js";
import CloudPage from "./pages/CloudPage.js";
import CompanySignUpComponent from './pages/CompanySignUpPage.js';
import PendingCloudPage from './pages/PendingCloudPage.js';

class AppController extends Component{
    constructor(props){
        super(props);

        this.state = {
            firstTimeLoad:1,
            pageLoaded: true,
            signingUpCompany: false,
        }
    }

    componentDidMount() {
        console.log('AppController componentDidMount');
        this.startMockPageLoading();
        this.props.fetchSessionData();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {pageLoaded, signingUpCompany} = this.state;
        var {appPage, cloudPage} = this.props;

        if(pageLoaded !== nextState.pageLoaded
            || appPage !== nextProps.appPage
            || cloudPage !== nextProps.cloudPage
        || signingUpCompany !== nextState.signingUpCompany){
            return true;
        }

        return false;
    }

    startMockPageLoading(){
        var {pageLoaded,firstTimeLoad} = this.state;
        var timeoutVal = 2000;
        switch (firstTimeLoad) {
            case 1:timeoutVal = 3000;break;
            case 0:timeoutVal = 1500;break;
        }
        const pageLoading = setTimeout(() => {
            this.setState({pageLoaded:true});
        }, timeoutVal);
        return () => clearTimeout(pageLoading);
        this.setState({firstTimeLoad: 0 });
    }

    displayAppPage(){
        var {appPage} = this.props;

        switch(appPage){
            case 'notifications' : return (<NotificationsPage key={v4()} />) ;break;
            case 'messaging' : return (<MessagesPage key={v4()} />) ;break;
            case 'home' : return (<CloudPage key={v4()} />) ;break;
        }
    }

    toggleCloudSignUp(toggle){
        this.setState({signingUpCompany: toggle});
    }

    render(){
        var {sessionData} = this.props;
        var {pageLoaded, signingUpCompany} = this.state;

        return (
            <>
                {
                    pageLoaded ?
                        <>
                            {sessionData.company_link == null ?
                                <div className={"content-wrap algn-cntr"}>
                                    <div className={"outr-header-bar content-wrap algn-cntr"}>
                                        <HeaderComponent key={v4()}/>
                                    </div>
                                    <div className={"inr-content body-content-wrap algn-cntr"}>
                                        <>
                                            {signingUpCompany ?
                                                <CompanySignUpComponent key={v4()} toggleCloudSignUp={(toggle)=>{this.toggleCloudSignUp(toggle)}}/>
                                                :
                                                <PendingCloudPage key={v4()} toggleCloudSignUp={(toggle)=>{this.toggleCloudSignUp(toggle)}}/>
                                            }
                                        </>
                                    </div>
                                </div>
                                :
                                <div className={"content-wrap algn-cntr"}>
                                    <div className={"outr-header-bar content-wrap algn-cntr"}>
                                        <HeaderComponent key={v4()}/>
                                    </div>
                                    <div className={"inr-content body-content-wrap algn-cntr"}>
                                        <div className={"content-wrap"}>
                                            {this.displayAppPage()}
                                        </div>
                                    </div>
                                </div>
                            }
                        </>
                        :
                        <div className={"content-wrap algn-cntr loading-page-dv"}>
                            <h4 className="webtitle">portfolioDemo</h4>
                            <div className={"page-loading-bar"}>
                                <div className={"page-loading-bar-inr"}></div>
                            </div>
                        </div>
                }
                </>
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
