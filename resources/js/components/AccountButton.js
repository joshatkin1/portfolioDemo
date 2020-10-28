import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import UserAccountSvg from '../../../public/images/user-circle-solid.svg';
import {Link} from "react-router-dom";

class AccountButton extends Component{
    constructor(props){
        super(props);

        this.state = {
            accountNavBarActive: false,
        }
    }

    componentDidMount() {

    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {accountNavBarActive} = this.state;
        if(accountNavBarActive !== nextState.accountNavBarActive){
            return true;
        }
        return false;
    }

    onClick(){
        var {accountNavBarActive} = this.state;
        console.log('toggle account nav bar');
        this.setState({
            accountNavBarActive : !accountNavBarActive
        });
        return true;
    }

    displayUserCompanyLinks(){
        var {sessionData} = this.props;
        var companyLinks = Object.assign([], sessionData.companyLinks);
        var displayComp = "";

        if(companyLinks.length > 0){
            displayComp = companyLinks.map((company)=>{
                let compID = company.id;
                let compName = company.company;
                return(
                    <button key={v4()}
                            value={compID}
                            onClick={(event) => {this.navigateToCompany(event)}}
                    >{compName}</button>
                );
            });
        }

        return displayComp;
    }

    navigateToCompany(event){
        var companyId = parseInt(event.target.value);
        console.log('navigate to company:', companyId);
    }

    render(){
        var {accountNavBarActive} = this.state;

        return (
            <div>
              <div className={"header-btn-icn"}
                   onClick={()=>{this.onClick()}}
              >
                  <img src={UserAccountSvg} alt={"your account"} height={"35px"}/>
              </div>
                <>
                    {
                        accountNavBarActive === true ?
                            <div className={"account-nav-bar algn-cntr"} style={{justifyContent:"space-between"}}>
                                <div className={"container"}>
                                    <button className={"account-nav-btn"}
                                            onClick={()=>{this.buttonOnClick()}}
                                    >Manage Account</button>
                                    <button className={"account-nav-btn"}>Settings</button>
                                    <div className={"acnt-nav-comp-sec"}>
                                        <p className={"nav-desc-title"}>Company Accounts</p>
                                        <div className={"acnt-nav-comp-dsp"}>
                                            {this.displayUserCompanyLinks()}
                                        </div>
                                    </div>
                                </div>
                                <button className={"account-sgn-out"} onClick={()=>{window.location.href='/logout'}}>Sign Out</button>
                            </div>
                            :
                            <></>
                    }
                </>
            </div>
        );
    }
}

AccountButton.propTypes = {
    sessionData: PropTypes.object.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
});

export default connect(mapStateToProps , {})(AccountButton);
