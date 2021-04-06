import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import UserAccountSvg from '../../../../../public/images/app.svg';
import CloudSvg from '../../../../../public/images/cloud-active.svg';
import AppNavBtn from "./AppNavBtn.js";
import {toggleAppNavViewable, closeAppNotif} from "../../actions/appActions.js";

class AppNavButtons extends Component{
    constructor(props){
        super(props);

        this.state = {
            accountBtnHovered: false,
        }
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {accountBtnHovered} = this.state;
        var {appNavBarViewable} = this.props;
        if(accountBtnHovered !== nextState.accountBtnHovered
            || appNavBarViewable !== nextProps.appNavBarViewable){
            return true;
        }
        return false;
    }

    onClick(){
        this.props.closeAppNotif();
        this.props.toggleAppNavViewable();
    }

    render(){
        var {appNavBarViewable} = this.props;
        var {accountBtnHovered} = this.state;

        return (
            <div className={"algn-cntr wrap-end"}>
                <div className={"wrap-space-between"} style={{width:"160px",marginRight:"50px"}}>
                    <AppNavBtn key={v4()} notifName={"messaging"}/>
                    <AppNavBtn key={v4()} notifName={"notifications"}/>
                </div>
                <div style={{marginRight:"20px"}}>
                    <div className={"app-btn-icn"}
                         onClick={()=>{this.onClick()}}
                    >
                        <img src={UserAccountSvg} alt={"account navigation"} height={"35px"}/>
                    </div>
                    <>
                        {
                            appNavBarViewable === true ?
                                <div className={"app-nav-bar"}>
                                    <div className={"app-nav-btn"}
                                         onClick={()=>{this.buttonOnClick()}}
                                    >Account</div>
                                    <div className={"app-nav-btn"}>Settings</div>
                                    <div className={"wrap-end"} style={{marginTop:"10px"}}>
                                        <div className={"app-nav-btn"} onClick={()=>{window.location.href='/logout'}}>Sign Out</div>
                                    </div>
                                </div>
                                :
                                <></>
                        }
                    </>
                </div>
                <div className={"header-btn-icn"}
                     onClick={()=>{window.location.href='/profile'}}
                     onMouseEnter={()=>{this.setState({accountBtnHovered : !accountBtnHovered})}}
                     onMouseLeave={()=>{this.setState({accountBtnHovered : !accountBtnHovered})}}
                >
                    <img src={CloudSvg} alt={"navigate to profile"} height={"35px"}/>
                    <div className={"algn-left acnt-nav-p-dv"}>
                        <p>Cloud</p>
                        <p className={"swtch-acnt-p"} style={accountBtnHovered ? {display: "block"}:{display: "none"}}>profile switch</p>
                    </div>
                </div>
            </div>
        );
    }
}

AppNavButtons.propTypes = {
    toggleAppNavViewable: PropTypes.func.isRequired,
    closeAppNotif: PropTypes.func.isRequired,
    appNavBarViewable: PropTypes.bool.isRequired,
};

const mapStateToProps = state => ({
    appNavBarViewable: state.app.appNavBarViewable,
});

export default connect(mapStateToProps , {toggleAppNavViewable, closeAppNotif})(AppNavButtons);
