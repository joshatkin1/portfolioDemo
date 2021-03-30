import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';
import {fetchSessionData} from '../actions/userActions.js';

class NotificationsPage extends Component {
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
        console.log('NotificationsPage componentDidMount');
        this.props.fetchSessionData();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }


    render(){
        return (
            <div className={"content-wrap wrap-start"}>
                notifications
            </div>
        );
    }
}

NotificationsPage.propTypes = {
    sessionData: PropTypes.object.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
});

export default connect(mapStateToProps , {navigateAppPage, fetchSessionData})(NotificationsPage);
