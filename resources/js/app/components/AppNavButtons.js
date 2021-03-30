import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import UserAccountSvg from '../../../../public/images/app.svg';
import {Link} from "react-router-dom";
import AppNavBtn from "../items/buttons/AppNavBtn.js";

class AppNavButtons extends Component{
    constructor(props){
        super(props);

        this.state = {
            accountNavBarActive: false,
        }
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
        this.setState({accountNavBarActive:!accountNavBarActive});
    }

    render(){
        var {accountNavBarActive} = this.state;

        return (
            <div className={"algn-cntr wrap-end"}>
                <div className={"wrap-space-between"} style={{width:"320px",marginRight:"50px"}}>
                    <AppNavBtn key={v4()} buttonPage={"cloud"}/>
                    <AppNavBtn key={v4()} buttonPage={"messaging"}/>
                    <AppNavBtn key={v4()} buttonPage={"notifications"}/>
                    <AppNavBtn key={v4()} buttonPage={"account"}/>
                </div>
                <div>
                    <div className={"header-btn-icn"}
                         onClick={()=>{this.onClick()}}
                    >
                        <img src={UserAccountSvg} alt={"account navigation"} height={"35px"}/>
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
                                    </div>
                                    <button className={"account-sgn-out"} onClick={()=>{window.location.href='/logout'}}>Sign Out</button>
                                </div>
                                :
                                <></>
                        }
                    </>
                </div>
            </div>
        );
    }
}

AppNavButtons.propTypes = {
};

const mapStateToProps = state => ({
});

export default connect(mapStateToProps , {})(AppNavButtons);
