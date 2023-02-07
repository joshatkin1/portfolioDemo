import React, {Component} from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import { v4 } from 'uuid';
import UserAccountSvg from "../../../../public/images/user-circle-solid.svg";

class HeaderComponent extends Component{
    constructor(props){
        super(props);

        this.state = {
            accountNavBarActive: false,
        }
    }

    componentDidMount() {}

    onClick(){
        var {accountNavBarActive} = this.state;

        this.setState({
            accountNavBarActive : !accountNavBarActive
        });
    }

    shouldComponentUpdate(nextProps, nextState, nextContext) {
        var {accountNavBarActive} = this.state;
        if(accountNavBarActive !== nextState.accountNavBarActive){
            return true;
        }
        return false;
    }

    render(){
        var {accountNavBarActive} = this.state;
        return (
            <header className={"header-bar wrap-middle algn-cntr"}>
                <div className={"col-3 wrap-start algn-cntr"}>
                    <a href={'/account'}>
                        <h4 className="webtitle">portfolioDemo</h4>
                    </a>
                </div>
                <div className={"col-9 wrap-end algn-cntr"}>
                    <div className={"algn-cntr wrap-end"}>
                        <a href={"/account"} className={"blubtn acnt-comp-btn"}>&#60; Back to Account</a>
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
                </div>
            </header>
        );
    }
}

HeaderComponent.propTypes = {
};

const mapStateToProps = state => ({
});

export default connect(mapStateToProps , {})(HeaderComponent);
