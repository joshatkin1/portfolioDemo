import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import MessagingIcon from '../../../../../public/images/messaging.svg';
import MessagingIconActive from '../../../../../public/images/messaging-active.svg';
import {toggleAppNavViewable, openAppNotif, closeAppNotif} from '../../actions/profileActions.js';
import NotificationsIcon from '../../../../../public/images/notifications.svg';
import NotificationsIconActive from '../../../../../public/images/notifications-active.svg';

class AppNavBtn extends Component{
    constructor(props){
        super(props);

        this.state = {
            buttonHovered: false,
        }
    }

    componentDidMount() {
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {buttonHovered} = this.state;
        var {appNotif} = this.props;

        if(appNotif !== nextProps.appNotif
            || buttonHovered !== nextState.buttonHovered){
            return true;
        }

        return false;
    }

    onClick(){
        var {appNotif, notifName, appNavBarViewable} = this.props;

        if(appNotif === notifName){
            this.props.closeAppNotif(notifName);
        }else{
            if(appNotif !== notifName){
                this.props.closeAppNotif(notifName);
            }
            this.props.openAppNotif(notifName);
        }

        if(appNavBarViewable){
            this.props.toggleAppNavViewable();
        }
    }

    onMouseEnter(){
        var {buttonHovered} = this.state;
        this.setState({buttonHovered : true});
    }

    onMouseLeave(){
        var {buttonHovered} = this.state;
        this.setState({buttonHovered : false});
    }

    displaySvg(){
        var {notifName} = this.props;
        var svgIcon = "";

        switch(notifName){
            case 'messaging': svgIcon = MessagingIcon ;break;
            case 'notifications': svgIcon = NotificationsIcon ;break;
        }

        return (<img src={svgIcon}/>);
    }

    displayActiveSvg(){
        var {notifName} = this.props;
        var svgIcon = "";

        switch(notifName){
            case 'messaging': svgIcon = MessagingIconActive ;break;
            case 'notifications': svgIcon = NotificationsIconActive ;break;
        }

        return (<img src={svgIcon} height={"30px"} />);
    }

    render(){
        var {buttonHovered} = this.state;
        var {notifName, appNotif} = this.props;

        return (
            <div className={"algn-top wrap-middle"}>
                <div className={appNotif === notifName ? "actv-nav-bar-btns":"nav-bar-btns"}
                        onClick={() => {this.onClick()}}
                        onMouseEnter={() => {this.onMouseEnter()}}
                        onMouseLeave={() => {this.onMouseLeave()}}
                >
                    {appNotif === notifName ?
                        this.displayActiveSvg()
                        :
                        this.displaySvg()
                    }
                    <p className={"nav-btn-p"} style={appNotif === notifName ? {color:"#1770E2"}:{}}>{notifName}</p>
                </div>
                { buttonHovered === true ?
                    <p className={"nav-bar-btn-lbl"}>{notifName}</p>
                    :
                    <></>
                }
            </div>
        );
    }
}

AppNavBtn.propTypes = {
    openAppNotif: PropTypes.func.isRequired,
    closeAppNotif:  PropTypes.func.isRequired,
    toggleAppNavViewable: PropTypes.func.isRequired,
    appNotif: PropTypes.string.isRequired,
    appNavBarViewable: PropTypes.bool.isRequired,
};

const mapStateToProps = state => ({
    appNotif: state.profile.appNotif,
    appNavBarViewable: state.profile.appNavBarViewable,
});

export default connect(mapStateToProps , {toggleAppNavViewable, openAppNotif, closeAppNotif})(AppNavBtn);
