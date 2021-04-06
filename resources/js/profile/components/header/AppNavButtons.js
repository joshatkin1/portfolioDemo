import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import UserAccountSvg from '../../../../../public/images/app.svg';
import AvatarSvg from '../../../../../public/images/profile.svg';
import AppNavBtn from "./AppNavBtn.js";
import {toggleAppNavViewable, closeAppNotif} from '../../actions/profileActions.js';

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
        var {sessionData} = this.props;
        if(accountBtnHovered !== nextState.accountBtnHovered
            || appNavBarViewable !== nextProps.appNavBarViewable
            || sessionData.name !== nextProps.sessionData.name
        ){
            return true;
        }
        return false;
    }

    onClick(){
        this.props.closeAppNotif();
        this.props.toggleAppNavViewable();
    }

    displayShortUserName(){
        var {sessionData} = this.props;
        var shortName = sessionData.name;
        if(_.isEmpty(sessionData)){return false;}
        if(shortName.length > 5){
            shortName = shortName.slice(0,4);
        }
        return shortName;
    }

    render(){
        var {appNavBarViewable} = this.props;
        var {accountBtnHovered} = this.state;

        return (
            <div className={"algn-cntr wrap-end"}>
                <div className={"wrap-space-between"} style={{width:"180px",marginRight:"50px"}}>
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
                     onClick={()=>{window.location.href='/app'}}
                     onMouseEnter={()=>{this.setState({accountBtnHovered : !accountBtnHovered})}}
                     onMouseLeave={()=>{this.setState({accountBtnHovered : !accountBtnHovered})}}
                >
                    <img src={AvatarSvg} alt={"account navigation"} height={"35px"}/>
                    <div className={"algn-left acnt-nav-p-dv"}>
                        <p>{this.displayShortUserName()}</p>
                        <p className={"swtch-acnt-p"} style={accountBtnHovered ? {display: "block"}:{display: "none"}}>cloud switch</p>
                    </div>
                </div>
            </div>
        );
    }
}

AppNavButtons.propTypes = {
    toggleAppNavViewable: PropTypes.func.isRequired,
    closeAppNotif: PropTypes.func.isRequired,
    sessionData: PropTypes.object.isRequired,
    appNavBarViewable:PropTypes.bool.isRequired,
};

const mapStateToProps = state => ({
    sessionData: state.user.sessionData,
    appNavBarViewable: state.profile.appNavBarViewable,
});

export default connect(mapStateToProps , {toggleAppNavViewable, closeAppNotif})(AppNavButtons);
