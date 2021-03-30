import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import AccountIcon from '../../../../../public/images/account.svg';
import AccountIconActive from '../../../../../public/images/account-active.svg';
import MessagingIcon from '../../../../../public/images/messaging.svg';
import MessagingIconActive from '../../../../../public/images/messaging-active.svg';
import {navigateAppPage} from '../../actions/appActions.js';
import NotificationsIcon from '../../../../../public/images/notifications.svg';
import NotificationsIconActive from '../../../../../public/images/notifications-active.svg';
import CloudIcon from '../../../../../public/images/cloud.svg';
import CloudIconActive from '../../../../../public/images/cloud-active.svg';

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
        var {appPage} = this.props;

        if(appPage !== nextProps.appPage
            || buttonHovered !== nextState.buttonHovered){
            return true;
        }

        return false;
    }

    onClick(){
        var {buttonPage} = this.props;
        this.props.navigateAppPage(buttonPage);
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
        var {buttonPage} = this.props;
        var svgIcon = "";

        switch(buttonPage){
            case 'account': svgIcon = AccountIcon ;break;
            case 'messaging': svgIcon = MessagingIcon ;break;
            case 'notifications': svgIcon = NotificationsIcon ;break;
            case 'cloud': svgIcon = CloudIcon ;break;
        }

        return (<img src={svgIcon} height={"30px"}/>);
    }

    displayActiveSvg(){
        var {buttonPage} = this.props;
        var svgIcon = "";

        switch(buttonPage){
            case 'account': svgIcon = AccountIconActive ;break;
            case 'messaging': svgIcon = MessagingIconActive ;break;
            case 'notifications': svgIcon = NotificationsIconActive ;break;
            case 'cloud': svgIcon = CloudIconActive ;break;
        }

        return (<img src={svgIcon} height={"30px"}/>);
    }

    render(){
        var {buttonHovered} = this.state;
        var {buttonPage, appPage} = this.props;

        return (
            <div className={"algn-top wrap-middle"}>
                <div className={appPage === buttonPage ? "actv-nav-bar-btns":"nav-bar-btns"}
                        onClick={() => {this.onClick()}}
                        onMouseEnter={() => {this.onMouseEnter()}}
                        onMouseLeave={() => {this.onMouseLeave()}}
                >
                    {appPage === buttonPage ?
                        this.displayActiveSvg()
                        :
                        this.displaySvg()
                    }
                    <p className={"nav-btn-p"} style={appPage === buttonPage ? {color:"#1770E2"}:{}}>{buttonPage}</p>
                </div>
                { buttonHovered === true ?
                    <p className={"nav-bar-btn-lbl"}>{buttonPage}</p>
                    :
                    <></>
                }
            </div>
        );
    }
}

AppNavBtn.propTypes = {
    navigateAppPage: PropTypes.func.isRequired,
    appPage: PropTypes.string.isRequired,
};

const mapStateToProps = state => ({
    appPage: state.app.appPage,
});

export default connect(mapStateToProps , {navigateAppPage})(AppNavBtn);
