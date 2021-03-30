import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';
import {fetchSessionData} from '../actions/userActions.js';

class MessagesPage extends Component {
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
        console.log('MessagesPage componentDidMount');
        this.props.fetchSessionData();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }


    render(){
        return (
            <div className={"content-wrap wrap-start"}>
                messages
            </div>
        );
    }
}

MessagesPage.propTypes = {
    sessionData: PropTypes.object.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
});

export default connect(mapStateToProps , {navigateAppPage, fetchSessionData})(MessagesPage);
