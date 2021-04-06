import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';

class CompanySignUpPage extends Component {
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
        console.log('CompanySignUpPage componentDidMount');
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        return false;
    }


    render(){
        return (
            <div className={"content-wrap wrap-start"}>
                company sign up page
            </div>
        );
    }
}

CompanySignUpPage.propTypes = {
};

const mapStateToProps = state => ({

});

export default connect(mapStateToProps , {navigateAppPage})(CompanySignUpPage);
