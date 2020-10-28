import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';
import {fetchSessionData} from '../actions/userActions.js';

//MAJOR CONTROLLER COMPONENTS
import NavComponent from '../components/NavComponent.js';
import HeaderComponent from '../components/HeaderComponent.js';
import SideNav from '../components/SideNav.js';

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
        var {appRequestStatusCode} = this.props;

        return false;
    }

    render(){
        return (
                <div className={"content-wrap algn-cntr"}>
                    <div className={"header-bar content-wrap algn-cntr"}>
                            <HeaderComponent key={v4()}/>
                    </div>
                    <div className={"content-wrap algn-cntr"}>
                            <div className={"wrap-start"}>
                                <div className={"side-nav-bar"}>
                                    <SideNav key={v4()} />
                                </div>
                                <div className={"content-wrap"} style={{justifyContent:"stretch"}}>

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
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
    appPage: state.app.appPage,
});

export default connect(mapStateToProps , {navigateAppPage, fetchSessionData})(AppController);
