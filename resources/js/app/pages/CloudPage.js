import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';
import {fetchSessionData} from '../actions/userActions.js';

class CloudPage extends Component {
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
        console.log('CloudPage componentDidMount');
        this.props.fetchSessionData();
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }


    render(){
        return (
            <div className={"content-wrap wrap-start"}>
                cloud
            </div>
        );
    }
}

CloudPage.propTypes = {
    sessionData: PropTypes.object.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
});

export default connect(mapStateToProps , {navigateAppPage, fetchSessionData})(CloudPage);
