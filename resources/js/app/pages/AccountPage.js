import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import {navigateAppPage} from '../actions/appActions.js';
import {fetchSessionData} from '../actions/userActions.js';
import UserAccountProfileImageSvg from "../../../../public/images/user-circle-solid.svg";
import AccountPageNavigation from "../components/AccountPageNavigation.js";
import {getCompanyLinkName} from '../actions/userActions.js';
import AccountContentSectionNavigation from '../components/AccountContentSectionNavigation.js';

class AccountPage extends Component {
    constructor(props){
        super(props);

        this.state = {}
    }

    componentDidMount() {
        console.log('AccountPage componentDidMount');
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {sessionData, accountPage, accountPageSection} = this.props;
        if(sessionData !== nextProps.sessionData
        || accountPage !== nextProps.accountPage
        || accountPageSection !== nextProps.accountPageSection){
            return true;
        }
        return false;
    }

    displayCompanyLinkName(){
        var {sessionData} = this.props;

        if(Object.keys(sessionData).length !== 0){
            if(sessionData.company_name){
                return(<p className={"prf-comp-nme-p"}
                          onClick={()=>{this.goToCompany()}}
                >{sessionData.company_name}</p>);
            }else{
                this.props.getCompanyLinkName();
            }
        }else{
            return (<div className="lds-default lds-default-sml">
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <p className={"spinner-load-p"}>loading</p>
            </div>);
        }
    }

    goToCompany(){
        this.props.navigateAppPage("cloud");
    }

    render(){
        var {sessionData, accountPageSection} = this.props;

        if(Object.keys(sessionData).length === 0){
            return (<div className="lds-default">
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <div></div><div></div>
                <p className={"spinner-load-p"}>loading</p>
            </div>);
        }else{
            return (
                <div className={"content-wrap algn-cntr"}>
                    <div className={"profile-page-content"}>
                        <div className={"content-wrap wrap-space-between profile-body-section"}>
                            <div className={"wrap-start"}>
                                <img src={UserAccountProfileImageSvg} alt={"profile image"} height={"120px"}/>
                                <div className={"container algn-top"}>
                                    <h3 className={"prf-dtl-p"}>{sessionData.name}</h3>
                                    <p className={"prf-dtl-p"}>{sessionData.job_title}</p>
                                    <div>
                                        {this.displayCompanyLinkName()}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <AccountPageNavigation key={v4()} />
                            </div>
                        </div>
                        <div className={"profile-body-section"}>
                            <div className={"accnt-pg-nav"}>
                                 <AccountContentSectionNavigation key={v4()} />
                            </div>
                            <div className={"accnt-bdy-sec-cnt"}>
                                {accountPageSection}
                            </div>
                        </div>
                    </div>
                </div>
            );
        }
    }
}

AccountPage.propTypes = {
    fetchSessionData: PropTypes.func.isRequired,
    navigateAppPage: PropTypes.func.isRequired,
    getCompanyLinkName: PropTypes.func.isRequired,
    sessionData: PropTypes.object.isRequired,
    accountPage: PropTypes.string.isRequired,
    accountPageSection: PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
    accountPage: state.account.accountPage,
    accountPageSection: state.account.accountPageSection,
});

export default connect(mapStateToProps , {navigateAppPage, fetchSessionData, getCompanyLinkName})(AccountPage);
