import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import ProfileIcon from '../../../../../public/images/personal.svg';
import ProfileIconActive from '../../../../../public/images/personal-active.svg';
import JobsIcon from '../../../../../public/images/jobs.svg';
import JobsIconActive from '../../../../../public/images/jobs-active.svg';
import {navigateAccountPage} from '../../actions/accountActions.js';

class AccountNavBtn extends Component{
    constructor(props){
        super(props);

        this.state = {
        }
    }

    componentDidMount() {
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {accountPage} = this.props;

        if(accountPage !== nextProps.accountPage){
            return true;
        }

        return false;
    }

    onClick(){
        var {buttonPage} = this.props;
        this.props.navigateAccountPage(buttonPage);
    }

    displaySvg(){
        var {buttonPage} = this.props;
        var svgIcon = "";

        switch(buttonPage){
            case 'profile': svgIcon = ProfileIcon ;break;
            case 'work': svgIcon = JobsIcon ;break;
        }

        return (<img src={svgIcon} height={"30px"}/>);
    }

    displayActiveSvg(){
        var {buttonPage} = this.props;
        var svgIcon = "";

        switch(buttonPage){
            case 'profile': svgIcon = ProfileIconActive ;break;
            case 'work': svgIcon = JobsIconActive ;break;
        }

        return (<img src={svgIcon} height={"30px"}/>);
    }

    render(){
        var {buttonPage, accountPage} = this.props;

        return (
            <div className={"algn-btm wrap-middle"}>
                <div className={accountPage === buttonPage ? "actv-nav-bar-btns acnt-nav-bar-btn":"nav-bar-btns acnt-nav-bar-btn"}
                     onClick={() => {this.onClick()}}
                >
                    {accountPage === buttonPage ?
                        this.displayActiveSvg()
                        :
                        this.displaySvg()
                    }
                    <p className={"nav-btn-p"} style={accountPage === buttonPage ? {color:"#1770E2"}:{}}>{buttonPage}</p>
                </div>
            </div>
        );
    }
}

AccountNavBtn.propTypes = {
    navigateAccountPage: PropTypes.func.isRequired,
    accountPage: PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    accountPage: state.account.accountPage,
});

export default connect(mapStateToProps , {navigateAccountPage})(AccountNavBtn);
