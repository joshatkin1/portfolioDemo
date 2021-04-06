import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import HeaderComponent from './components/header/HeaderComponent.js';
import {fetchSessionData} from './actions/userActions.js';

class ProfileController extends Component{
    constructor(props){
        super(props);

        this.state = {
            firstTimeLoad:1,
            pageLoaded: true,
        }
    }

    componentDidMount() {
        console.log('ProfileController componentDidMount');
        this.startMockPageLoading();
        this.loadControllerData();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {pageLoaded} = this.state;
        var {profilePage} = this.props;

        if(pageLoaded !== nextState.pageLoaded
           || profilePage !== nextProps.profilePage){
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

    loadControllerData(){
        this.props.fetchSessionData();
    }

    displayAppPage(){
        var {profilePage} = this.props;

        switch(profilePage){
            // case 'notifications' : return (<NotificationsPage key={v4()} />) ;break;
            // case 'messaging' : return (<MessagesPage key={v4()} />) ;break;
            // case 'home' : return (<CloudPage key={v4()} />) ;break;
        }
    }

    render(){
        var {pageLoaded} = this.state;
        return (
            <>
                {
                    pageLoaded ?
                        <div className={"content-wrap algn-cntr"}>
                            <div className={"outr-header-bar content-wrap algn-cntr"}>
                                <HeaderComponent key={v4()} />
                            </div>
                            <div className={"inr-content body-content-wrap algn-cntr"}>
                                <div className={"content-wrap"} style={{justifyContent:"stretch"}}>
                                    {/*{this.displayAppPage()}*/}
                                </div>
                            </div>
                        </div>
                    :
                        <div className={"content-wrap algn-cntr loading-page-dv"}>
                            <h4 className="webtitle">workcloud</h4>
                            <div className={"page-loading-bar"}>
                                <div className={"page-loading-bar-inr"}></div>
                            </div>
                        </div>
                }
            </>
        );
    }
}

ProfileController.propTypes = {
    fetchSessionData: PropTypes.func.isRequired,
};

const mapStateToProps = state => ({

});

export default connect(mapStateToProps , {fetchSessionData})(ProfileController);
