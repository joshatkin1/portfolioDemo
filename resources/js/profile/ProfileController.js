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
        }
    }

    componentDidMount() {
        console.log('ProfileController componentDidMount');
        this.props.fetchSessionData();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {profilePage} = this.props;

        if(profilePage !== nextProps.profilePage){
            return true;
        }

        return false;
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
        return (
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
        );
    }
}

ProfileController.propTypes = {
    fetchSessionData: PropTypes.func.isRequired,
};

const mapStateToProps = state => ({

});

export default connect(mapStateToProps , {fetchSessionData})(ProfileController);
